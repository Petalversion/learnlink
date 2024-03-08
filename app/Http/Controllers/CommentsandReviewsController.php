<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\Reviews;
use App\Models\Instructor_info;
use App\Models\Student_info;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class CommentsandReviewsController extends Controller
{

    public function storeQuestion(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'lesson_id' => 'required|string|max:255',
                'course_id' => 'required|string|max:255',
                'student_id' => 'required|string|max:255',
                'comment' => 'required|string|max:255',
            ]);

            // Create a new question using the validated data
            $question = Questions::create([
                'lesson_id' => $validatedData['lesson_id'],
                'course_id' => $validatedData['course_id'],
                'student_id' => $validatedData['student_id'],
                'comment' => $validatedData['comment'],
                'comment_id' => $this->generateCommentId(),
            ]);

            // Save the question
            $question->save();

            return redirect()->back()->with('success', 'Question created successfully');
        } catch (ValidationException $e) {
            // Handle validation errors
            Session::flash('errors', $e->validator->errors());
            return redirect()->back()->withInput();
        }
    }

    public function storeReview(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'score' => 'required',
                'course_id' => 'required|string|max:255',
                'student_id' => 'required|string|max:255',
                'comment' => 'required|string|max:255',
            ]);

            // Create a new question using the validated data
            $review = Reviews::create([
                'score' => $validatedData['score'],
                'course_id' => $validatedData['course_id'],
                'student_id' => $validatedData['student_id'],
                'comment' => $validatedData['comment'],
                'review_id' => $this->generateCommentId(),
            ]);

            // Save the question
            $review->save();

            return redirect()->back()->with('success', 'Reviewed successfully');
        } catch (ValidationException $e) {
            // Handle validation errors
            Session::flash('errors', $e->validator->errors());
            return redirect()->back()->withInput();
        }
    }

    private function generateCommentId()
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
    }

    public function instructorRecentComments()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructorId = Auth::user()->instructor_id;
            $userId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            $instructor = Instructor::where('instructor_id', $user->instructor_id)->first();
            $all_student_comments = [];

            // Retrieve all courses associated with the instructor
            $courses = $instructor->courses;

            // Loop through each course
            $all_student_comments = Questions::whereIn('course_id', $instructor->courses->pluck('course_id'))
                ->with(['lesson.course', 'student', 'answers' => function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                }, 'student_info'])
                ->whereDoesntHave('answers')
                ->get();

            $questionNotif = count($all_student_comments);

            return view('instructor.questions', compact('name', 'instructor_info', 'user', 'all_student_comments', 'questionNotif'));
        }
    }

    public function instructorComments($lesson_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructorId = Auth::user()->instructor_id;
            $userId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            $instructor = Instructor::where('instructor_id', $user->instructor_id)->first();
            $all_student_comments = [];

            // Retrieve all courses associated with the instructor
            $courses = $instructor->courses;

            $lesson = Lesson::where('id', $lesson_id)->first();

            if (!$lesson) {
                return redirect()->route('instructor.course.course')->with('error', 'Lesson not found.');
            }

            $course = Course::where('course_id', $lesson->course_id)->first();
            $owner = $course->instructor_id;
            $back = $course->id;
            if ($owner !== $user->instructor_id) {
                return redirect()->route('instructor.course.course')->with('error', 'Lesson not found.');
            }

            $all_student_comments = Questions::whereIn('course_id', $instructor->courses->pluck('course_id'))
                ->where('lesson_id', $lesson->lesson_id)
                ->with(['lesson.course', 'student', 'answers' => function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                }, 'student_info'])
                ->whereHas('answers')
                ->get();


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



            return view('instructor.course.questions', compact('name', 'instructor_info', 'user', 'all_student_comments', 'back', 'questionNotif'));
        }
    }

    public function storeAnswer(Request $request)
    {
        $validatedData = $request->validate([
            'comment_id' => 'required|string|max:255',
            'instructor_id' => 'required|string|max:255',
            'comment' => 'required|string|max:255',
        ]);

        $answer = Answers::create([
            'comment_id' => $validatedData['comment_id'],
            'instructor_id' => $validatedData['instructor_id'],
            'comment' => $validatedData['comment'],
        ]);
        // Save the course before attaching tags and categories
        $answer->save();

        return redirect()->route('instructor.questions')->with('success', 'Question successfully answered!');
    }

    public function reviews()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $name = Auth::user()->name;
            $user = Auth::user();
            $userId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            $instructor = Instructor::where('instructor_id', $user->instructor_id)->first();
            $all_student_reviews = [];

            // Retrieve all courses associated with the instructor
            $courses = $instructor->courses;

            // Loop through each course
            foreach ($courses as $course) {
                // Retrieve student comments for the current course
                $student_reviews = Reviews::where('course_id', $course->course_id)->get();
                // Merge the student comments into the array
                $all_student_reviews = array_merge($all_student_reviews, $student_reviews->toArray());
            }

            $reviewIds = array_column($all_student_reviews, 'review_id');

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

            return view('instructor.inquiries.reviews', compact('name', 'instructor_info', 'user', 'all_student_reviews', 'questionNotif'));
        }
    }
}
