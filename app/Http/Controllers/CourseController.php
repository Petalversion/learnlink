<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tag;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Instructor_info;
use App\Models\Student_info;
use App\Models\Category;
use App\Models\Transactions;
use App\Models\Cart;
use App\Models\Exam;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            // Retrieve the currently authenticated user
            $instructor = Auth::guard('instructor')->user();

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            // Get only the courses created by the current instructor
            $courses = Course::where('instructor_id', $instructor->instructor_id)->paginate(10);

            return view('instructor.course.course', compact('courses', 'instructor', 'name', 'instructor_info'));
        }
    }

    public function createCourse()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $instructor = Auth::guard('instructor')->user();
            $tags = Tag::all();
            $categories = Category::all();
            $course_id = Str::random(9);

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            return view('instructor.course.course-create', compact('tags', 'categories', 'course_id', 'instructor', 'name', 'instructor_info'));
        }
    }

    public function storeCourse(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'required|string',
            'wyl' => 'required|string',
            'requirements' => 'required|string',
            'paid' => 'nullable|boolean',
            'free' => 'nullable|boolean',
            'difficulty' => 'required|in:beginner,intermediate,expert',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'tags' => 'required|array',
            'amount' => 'nullable|numeric|min:0',
        ]);

        // Get the authenticated instructor
        $instructor = Auth::guard('instructor')->user();
        $validatedData['instructor_id'] = $instructor->instructor_id;
        $validatedData['course_id'] = Str::random(9);

        // Set the status based on the button clicked
        $status = 'draft';
        $validatedData['status'] = $status;


        $course = Course::create($validatedData);

        // Save the course before attaching tags and categories
        $course->save();

        // Get the tag IDs from the request
        $tags = $request->input('tags');

        // Attach tags and categories to the course
        $course->tags()->sync($request->input('tags'));


        // If not saved as draft, redirect to course view
        return redirect()->route('instructor.course.course', $course->course_id)
            ->with('success', 'Course saved as draft.');
    }

    public function courseView($course_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $course = Course::where('course_id', $course_id)->first();

            if (!$course) {
                return redirect()->route('instructor.course.course')->with('error', 'Course not found.');
            }
            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();

            return view('instructor.course.course-view', compact('course', 'name', 'instructor_info'));
        }
    }

    public function courseEdit($course_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $course = Course::where('course_id', $course_id)->first();
            $lessons = count($course->lessons);
            $quizzes = count($course->quiz);

            if ($lessons == 0 || $quizzes == 0) {
                $combo = 0;
            } else {
                $combo = 1;
            }

            if (!$course) {
                return redirect()->route('instructor.course.course')->with('error', 'Course not found.');
            }
            $tags = Tag::all();
            $categories = Category::all();

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            return view('instructor.course.course-edit', compact('course', 'tags', 'categories', 'name', 'instructor_info', 'combo'));
        }
    }



    public function update(Request $request, $course_id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'summary' => 'required',
            'description' => 'required|string',
            'wyl' => 'required|string',
            'requirements' => 'required|string',
            'paid' => 'nullable|boolean',
            'free' => 'nullable|boolean',
            'draft' => 'nullable|boolean',
            'difficulty' => ['required', 'in:beginner,intermediate,expert'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'tags' => 'required|array|min:1',
            'amount' => 'nullable|numeric',

            // Add any other validation rules for your fields
        ]);



        $course = Course::where('course_id', $course_id)->first();
        if ($request->hasFile('image')) {
            // Add logic to store and handle the uploaded image
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
            $course->image = $imagePath;
        }
        if (!$course) {
            return redirect()->route('instructor.course.course')->with('error', 'Course not found.');
        }


        $course->title = $request->input('title');
        $course->summary = $request->input('summary');
        $course->description = $request->input('description');
        $course->wyl = $request->input('wyl');
        $course->requirements = $request->input('requirements');
        $course->paid = $request->has('paid');
        $course->difficulty = $request->input('difficulty');
        $course->amount = $request->input('amount');
        $course->status = $request->input('status', 'draft'); // Default to draft if no status is provided
        $course->save();

        // Sync tags and categories for the course
        $course->tags()->sync($request->input('tags'));

        return redirect()->route('instructor.course.course-edit', ['course_id' => $course->course_id])->with('success', 'Course updated successfully.');
    }

    // Delete a course
    public function destroy($course_id)
    {
        $course = Course::where('course_id', $course_id)->first();

        if (!$course) {
            return redirect()->route('instructor.course.course')->with('error', 'Course not found.');
        }

        $course->delete();

        return redirect()->route('instructor.course.course')->with('success', 'Course deleted successfully.');
    }

    public function details($course_id)
    {

        $details = Course::where('course_id', $course_id)->get();
        foreach ($details as $detail) {
            $instructor = $detail->instructor_id;
        }
        $course_list = Course::where('course_id', '!=', $course_id)->where('status', 'publish')->where('instructor_id', $instructor)->inRandomOrder()->take(4)->get();
        // $userId = Auth::guard('student')->user()->student_id;
        // $cart = Cart::where('student_id', $userId)->count();
        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();

        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        //
        if (Auth::guard('student')->check()) {
            $sid = Auth::guard('student')->user()->student_id;
            $check_course = Transactions::where('student_id', $sid)->get();
            $checked_courses = [];

            if ($check_course->isNotEmpty()) {
                foreach ($check_course as $course) {
                    $checked_courses = collect($course->course_id_amount)->pluck('course_id')->toArray();
                }

                // Iterate over $courseIds array
                foreach ($checked_courses as $checked_id) {
                    if ($checked_id == $course_id) {
                        $userId = Auth::guard('student')->user()->student_id;
                        $name = Auth::guard('student')->user()->name;
                        $user = Auth::guard('student');
                        $user_info = Student_info::where('student_id', $userId)->first();
                        $courses = Transactions::where('student_id', $userId)->get();
                        $courseIds = $courses->flatMap(function ($transaction) {
                            return collect($transaction->course_id_amount)->pluck('course_id');
                        })->unique();
                        $courseinfo = [];
                        foreach ($courseIds as $courseId) {
                            $courseData = Course::where('course_id', $courseId)->first();
                            if ($courseData !== null) {
                                $courseinfo[] = $courseData;
                                $lessonData = Lesson::where('course_id', $courseData->course_id)->first();
                                if ($lessonData !== null) {
                                    $courseData->first_lesson = $lessonData;
                                }
                            }
                        }
                        return view('student.courses', compact('userId', 'courseinfo', 'name', 'user_info'));
                    }
                }
            }
        }
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;
        return view('course_details', compact('details', 'course_list', 'cart', 'user_info', 'instructor_info'));
    }
}
