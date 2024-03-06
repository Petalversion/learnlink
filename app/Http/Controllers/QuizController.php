<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Lecture;
use App\Models\Course;
use App\Models\Instructor_info;
use App\Models\Exam;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    private function generateQuizId()
    {
        return Str::random(9);
    }

    public function create($course_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $name = Auth::guard('instructor')->user()->name;
            $user = Auth::guard('instructor')->user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            $courses = Course::where('instructor_id', $user->instructor_id)->where('id', $course_id)->first();
            if (!$courses) {
                return redirect()->route('instructor.course.course');
            }

            return view('instructor.exam.question-add', compact('courses', 'name', 'instructor_info'));
        }
    }

    public function store(Request $request)
    {
        if (($request->input('type')) == 'MC') {
            $request->validate([
                'type' => 'required',
                'question' => 'required',
                'answer' => 'required',
                'choice2' => 'required',
                'choice3' => 'required',
                'choice4' => 'required',
                'course_id' => 'required|exists:courses,course_id',
            ]);
        } else {
            $request->validate([
                'type' => 'required',
                'question' => 'required',
                'answer' => 'required',
                'course_id' => 'required|exists:courses,course_id',
            ]);
        }
        $course_id = $request->input('course_id');
        if (($request->input('type')) == 'MC') {
            $choices = [
                $request->input('answer'),
                $request->input('choice2'),
                $request->input('choice3'),
                $request->input('choice4'),
            ];
        } else {
            if (($request->input('answer')) == 'True') {
                $choices = [
                    $request->input('answer'),
                    "False",
                ];
            } else {
                $choices = [
                    $request->input('answer'),
                    "True",
                ];
            }
        }


        // Create the lesson first
        $lesson = Exam::create([
            'exam_id' => $this->generateQuizId(),
            'course_id' => $request->input('course_id'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'type' => $request->input('type'),
            'choices' => $choices,
        ]);

        $id = Course::where('course_id', $course_id)->first();
        return redirect()->route('instructor.exam.question-create', ['course_id' => $id->id])
            ->with('success', 'Question Successfully Added!');
    }


    public function destroy($exam_id)
    {
        // Find the lesson by ID
        $quiz = Exam::where('id', $exam_id)->first();
        // Check if the lesson exists
        if (!$quiz) {
            return redirect()->route('instructor.course.course-view', ['course_id' => $quiz->course->id])->with('error', 'Question does not exist!');
        }
        // Get the course ID before deleting the lesson
        $course_id = $quiz->course->id;
        // Implement any additional authorization logic if needed (e.g., check if the authenticated user owns the lesson)
        // Delete the lesson
        $quiz->delete();
        // Redirect to the course edit page with the same course_id
        return redirect()->route('instructor.course.course-view', ['course_id' => $course_id])
            ->with('success', 'Question has been deleted!');
    }

    public function examEdit($exam_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $quiz = Exam::where('id', $exam_id)->first();
            $name = Auth::guard('instructor')->user()->name;
            $user = Auth::guard('instructor')->user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            if (!$quiz) {
                return redirect()->route('instructor.course.course')->with('error', 'Question not found.');
            }


            $exam = Course::where('course_id', $quiz->course_id)->first();
            $owner = $exam->instructor_id;


            if ($owner !== $user->instructor_id) {
                return redirect()->route('instructor.course.course')->with('error', 'Question not found.');
            }

            return view('instructor.exam.question-edit', compact('quiz', 'name', 'instructor_info'));
        }
    }

    public function update(Request $request, $exam_id)
    {
        if (($request->input('type')) == 'MC') {
            $request->validate([
                'type' => 'required',
                'question' => 'required',
                'answer' => 'required',
                'choice2' => 'required',
                'choice3' => 'required',
                'choice4' => 'required',
            ]);
        } else {
            $request->validate([
                'type' => 'required',
                'question' => 'required',
                'answer' => 'required',
            ]);
        }

        $quiz = Exam::where('id', $exam_id)->first();

        if (!$quiz) {
            return redirect()->route('instructor.course.course-view')->with('error', 'Question not found.');
        }
        if (($request->input('type')) == 'MC') {
            $choices = [
                $request->input('answer'),
                $request->input('choice2'),
                $request->input('choice3'),
                $request->input('choice4'),
            ];
        } else {
            if (($request->input('answer')) == 'True') {
                $choices = [
                    $request->input('answer'),
                    "False",
                ];
            } else {
                $choices = [
                    $request->input('answer'),
                    "True",
                ];
            }
        }

        $quiz->question = $request->input('question');
        $quiz->answer = $request->input('answer');
        $quiz->choices = $choices;
        $quiz->save();

        return redirect()->route('instructor.exam.question-edit', ['exam_id' => $quiz->id])->with('success', 'Question updated successfully.');
    }
}
