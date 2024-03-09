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
use App\Models\QuizAttemptCounter;
use App\Models\Reviews;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function certificate($course_id)
    {
        $name = Auth::guard('student')->user()->name;
        $student = Auth::guard('student')->user()->student_id;
        $course = Course::where('course_id', $course_id)->first();
        $certificate = Certificate::where('course_id', $course_id)->where('student_id', $student)->first();
        if ($certificate) {
            $courseName = $course->title;
            $date = $certificate->created_at;
            $Instructor = $course->instructor->name;
            $cid = $certificate->result_id;
            return view('cc', compact('name', 'courseName', 'date', 'Instructor', 'cid'));
        }
        return redirect()->route('student.certificates');
    }

    public function examAttempt(Request $request)
    {
        $result_id = $this->generateResultId();
        $student = Auth::user()->student_id;
        $percentage = $request->input('percentage');
        $course_id = $request->input('course_id');
        $attempt = QuizAttemptCounter::where('student_id', $student)->where('course_id', $course_id)->first();
        if ($attempt) {
            $score = QuizAttemptCounter::where('student_id', $student)->where('course_id', $course_id)->first();
            if ($score->attempt < 3) {
                $score->attempt = $score->attempt + 1;
                if ($score->score <= $percentage) {
                    $score->score = $percentage;
                }
                $score->save();

                if ($percentage >= 75) {
                    $certificate = new Certificate();
                    $certificate->course_id = $course_id;
                    $certificate->result_id = $score->result_id;
                    $certificate->student_id = $student;
                    $certificate->save();
                }
            } else {
                $score->attempt = 1;
                if ($score->score <= $percentage) {
                    $score->score = $percentage;
                }
                $score->save();

                if ($percentage >= 75) {
                    $certificate = new Certificate();
                    $certificate->course_id = $course_id;
                    $certificate->result_id = $score->result_id;
                    $certificate->student_id = $student;
                    $certificate->save();
                }
            }
            return redirect()->back();
        } else {
            $attempt = 0;
            $score = new QuizAttemptCounter();
            $score->course_id = $course_id;
            $score->attempt = $attempt;
            $score->result_id = $result_id;
            $score->student_id = $student;
            $score->score = $percentage;
            $score->save();

            if ($percentage >= 75) {
                $certificate = new Certificate();
                $certificate->course_id = $course_id;
                $certificate->result_id = $result_id;
                $certificate->student_id = $student;
                $certificate->save();
            }

            return redirect()->back();
        }
    }

    private function generateResultId()
    {
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
        return $random_string;
    }
}
