<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tag;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Instructor_info;
use App\Models\Instructor;
use App\Models\Questions;
use App\Models\Student_info;
use App\Models\Category;
use App\Models\Transactions;
use App\Models\Cart;
use App\Models\Exam;
use App\Models\Reviews;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending' || $status == 'Declined') {
            return redirect('/instructor/profile');
        } else {
            // Retrieve the currently authenticated user
            $instructor = Auth::guard('instructor')->user();
            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            // Get only the courses created by the current instructor
            $courses = Course::where('instructor_id', $instructor->instructor_id)->paginate(10);

            $instructorId = Auth::user()->instructor_id;
            $instructor_un = Instructor::where('instructor_id', $user->instructor_id)->first();
            $all_student_comments_un = [];
            // Loop through each course
            $all_student_comments_un = Questions::whereIn('course_id', $instructor_un->courses->pluck('course_id'))
                ->with(['lesson.course', 'student', 'answers' => function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                }, 'student_info'])
                ->whereDoesntHave('answers')
                ->get();

            $questionNotif = count($all_student_comments_un);

            return view('instructor.course.course', compact('courses', 'instructor', 'name', 'instructor_info', 'questionNotif'));
        }
    }

    public function createCourse()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending' || $status == 'Declined') {
            return redirect('/instructor/profile');
        } else {

            $instructor = Auth::guard('instructor')->user();
            $tags = Tag::all();
            $categories = Category::all();
            $course_id = Str::random(9);

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();

            $instructorId = Auth::user()->instructor_id;
            $instructor_un = Instructor::where('instructor_id', $user->instructor_id)->first();
            $all_student_comments_un = [];
            // Loop through each course
            $all_student_comments_un = Questions::whereIn('course_id', $instructor_un->courses->pluck('course_id'))
                ->with(['lesson.course', 'student', 'answers' => function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                }, 'student_info'])
                ->whereDoesntHave('answers')
                ->get();

            $questionNotif = count($all_student_comments_un);
            return view('instructor.course.course-create', compact('tags', 'categories', 'course_id', 'instructor', 'name', 'instructor_info', 'questionNotif'));
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
            'difficulty' => 'required|in:beginner,intermediate,expert',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'category' => 'required',
            'amount' => 'nullable|numeric|min:0',
            'tags' => 'required',
        ]);

        // Get the authenticated instructor
        $instructor = Auth::guard('instructor')->user();
        $validatedData['instructor_id'] = $instructor->instructor_id;
        $validatedData['course_id'] = Str::random(9);
        $option_validate = $request->input('options');

        if ($option_validate == 0) {
            $validatedData['free'] = 0;
            $validatedData['paid'] = 1;
        } else {
            $validatedData['free'] = 1;
            $validatedData['paid'] = 0;
            $validatedData['amount'] = 0;
        }

        // dd($request->input('tags'));

        // Set the status based on the button clicked
        $status = 'draft';
        $validatedData['status'] = $status;

        if ($request->hasFile('image')) {
            // Add logic to store and handle the uploaded image
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $course = Course::create($validatedData);

        // Save the course before attaching tags and categories
        $course->save();

        // Get the category IDs from the request
        $category = $request->input('category');

        // Attach tags and categories to the course
        $course->categories()->sync($request->input('category'));


        // If not saved as draft, redirect to course view
        return redirect()->route('instructor.course.course-view', $course->id)
            ->with('success', 'Course saved as draft.');
    }

    public function courseView($course_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        $instructor_id = Auth::guard('instructor')->user()->instructor_id;
        if ($status == 'Pending' || $status == 'Declined') {
            return redirect()->route('instructor.profile');
        } else {


            $course = Course::where('instructor_id', $instructor_id)->where('id', $course_id)->first();

            if ($course) {
                $lessons = count($course->lessons);
                $quizzes = count($course->quiz);

                if ($lessons == 0 || $quizzes < 25) {
                    $combo = 0;
                } else {
                    $combo = 1;
                }

                if (!$course) {
                    return redirect()->route('instructor.course.course')->with('error', 'Course not found.');
                }
                $name = Auth::user()->name;
                $user = Auth::user();
                $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();

                $course_rating = Reviews::where('course_id', $course->course_id)->get();
                $rounded_rating = round($course_rating->avg('score'), 1);
                $course_count = count($course_rating);

                $instructorId = Auth::user()->instructor_id;
                $instructor = Instructor::where('instructor_id', $user->instructor_id)->first();
                $all_student_comments_un = [];
                // Loop through each course
                $all_student_comments_un = Questions::whereIn('course_id', $instructor->courses->pluck('course_id'))
                    ->with(['lesson.course', 'student', 'answers' => function ($query) use ($instructorId) {
                        $query->where('instructor_id', $instructorId);
                    }, 'student_info'])
                    ->whereDoesntHave('answers')
                    ->get();

                $questionNotif = count($all_student_comments_un);

                return view('instructor.course.course-view', compact('course', 'name', 'instructor_info', 'combo', 'rounded_rating', 'course_count', 'questionNotif'));
            }
            return redirect()->route('instructor.course.course');
        }
    }

    public function courseEdit($course_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        $instructor_id = Auth::guard('instructor')->user()->instructor_id;
        if ($status == 'Pending' || $status == 'Declined') {
            return redirect('/instructor/profile');
        } else {

            $course = Course::where('instructor_id', $instructor_id)->where('id', $course_id)->first();
            if ($course) {
                $lessons = count($course->lessons);
                $quizzes = count($course->quiz);

                if ($lessons == 0 || $quizzes < 25) {
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
                $instructorId = Auth::user()->instructor_id;
                $instructor = Instructor::where('instructor_id', $user->instructor_id)->first();
                $all_student_comments_un = [];
                // Loop through each course
                $all_student_comments_un = Questions::whereIn('course_id', $instructor->courses->pluck('course_id'))
                    ->with(['lesson.course', 'student', 'answers' => function ($query) use ($instructorId) {
                        $query->where('instructor_id', $instructorId);
                    }, 'student_info'])
                    ->whereDoesntHave('answers')
                    ->get();

                $questionNotif = count($all_student_comments_un);

                return view('instructor.course.course-edit', compact('course', 'tags', 'categories', 'name', 'instructor_info', 'combo', 'questionNotif'));
            }
            return redirect()->route('instructor.course.course');
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
            'difficulty' => ['required', 'in:beginner,intermediate,expert'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'category' => 'required',
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

        $option_validate = $request->input('options');

        if ($option_validate == 0) {
            $course->free = 0;
            $course->paid = 1;
            $course->amount = $request->input('amount');
        } else {
            $course->free = 1;
            $course->paid = 0;
            $course->amount = 0;
        }

        $course->title = $request->input('title');
        $course->summary = $request->input('summary');
        $course->description = $request->input('description');
        $course->wyl = $request->input('wyl');
        $course->requirements = $request->input('requirements');
        $course->category = $request->input('category');
        $course->difficulty = $request->input('difficulty');
        $course->status = $request->input('status', 'draft');
        $course->tags = $request->input('tags');
        $course->save();



        return redirect()->route('instructor.course.course-edit', ['course_id' => $course->id])->with('success', 'Course updated successfully.');
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
        $course_check = Course::where('id', $course_id)->where('status', 'publish')->first();
        if ($course_check) {
            $instructor = $course_check->instructor_id;
            $course_list = Course::where('id', '!=', $course_id)->where('status', 'publish')->where('instructor_id', $instructor)->inRandomOrder()->take(4)->get();
            $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
            $user_info = Student_info::where('student_id', $userId)->first();
            $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
            $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();

            $course_rating = Reviews::where('course_id', $course_check->course_id)->get();
            $rounded_rating = round($course_rating->avg('score'), 1);
            $course_count = count($course_rating);

            $reviewsData = Reviews::select('course_id', \DB::raw('AVG(score) as average_score'), \DB::raw('COUNT(*) as reviewer_count'))
                ->groupBy('course_id')
                ->get();

            // Associate average reviews and reviewer counts with courses
            $coursesWithReviewsData = $course_list->map(function ($course) use ($reviewsData) {
                $reviewData = $reviewsData->where('course_id', $course->course_id)->first();
                $course->average_score = $reviewData ? $reviewData->average_score : 0;
                $course->reviewer_count = $reviewData ? $reviewData->reviewer_count : 0;
                return $course;
            });

            $instr = Instructor::where('instructor_id', $instructor)->first();

            if (Auth::guard('student')->check()) {
                $sid = Auth::guard('student')->user()->student_id;
                $check_course = Transactions::where('student_id', $sid)->get();
                $checked_courses = [];

                if ($check_course) {

                    foreach ($check_course as $course) {
                        // Convert to collection, pluck 'course_id', and convert to array
                        $current_course_ids = collect($course->course_id_amount)->pluck('course_id')->toArray();
                        // Merge the current course IDs into the accumulating array
                        $checked_courses = array_merge($checked_courses, $current_course_ids);
                    }
                    // Iterate over $courseIds array
                    foreach ($checked_courses as $checked_id) {
                        if ($checked_id == $course_check->course_id) {
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
            $instructor_courses = Course::where('status', 'publish')->where('instructor_id', $instructor)->get();

            $totalCourses = count($instructor_courses);

            $instructorId = $course_check->instructor_id;
            $courseIds = Course::where('instructor_id', $instructorId)->pluck('course_id');

            $transactions = Transactions::where(function ($query) use ($courseIds) {
                foreach ($courseIds as $courseId) {
                    $query->orWhereJsonContains('course_id_amount', [['course_id' => $courseId]]);
                }
            })->get();

            $instructor_reviews = Reviews::whereIn('course_id', $courseIds)->get();

            $labels = [];
            $courseTitles = Course::whereIn('course_id', $courseIds)->pluck('title', 'course_id');
            // Iterate over each data point
            $labels = $courseTitles->toArray();
            $courseCounts = array_fill_keys($labels, 0);

            // Iterate over each data point
            foreach ($transactions as $transaction) {
                // Extract course_id and amount from each transaction
                foreach ($transaction->course_id_amount as $item) {
                    // Check if the course ID is in the $courseIds array
                    if (in_array($item['course_id'], $courseIds->toArray())) {
                        // Increment the count for the corresponding course title
                        $courseCounts[$courseTitles[$item['course_id']]]++;
                    }
                }
            }

            // If a course doesn't appear in any transaction, its count will remain 0
            $courseCounts = array_values($courseCounts);
            $totalStudents = array_sum($courseCounts);
            $totalReviews = count($instructor_reviews);

            $AverageReviews = 0;
            foreach ($instructor_reviews as $items) {
                $AverageReviews += $items->score;
            }
            $totalAverageReviews = 0;
            if ($AverageReviews > 0) {
                $totalAverageReviews = $AverageReviews / $totalReviews;
            }


            $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;
            return view('course_details', compact('coursesWithReviewsData', 'course_count', 'rounded_rating', 'course_check', 'course_list', 'cart', 'user_info', 'instructor_info', 'totalCourses', 'totalStudents', 'totalReviews', 'totalAverageReviews', 'instr'));
        }
        return redirect()->route('index');
    }

    public function updateStatus(Request $request, $course_id)
    {

        $course = Course::where('course_id', $course_id)->first();

        if (!$course) {
            return redirect()->route('instructor.course.course')->with('error', 'Course not found.');
        }

        $course->status = $request->input('status', 'draft'); // Default to draft if no status is provided
        $course->save();

        return redirect()->route('instructor.course.course-view', ['course_id' => $course->id])->with('success', 'Status updated successfully.');
    }
}
