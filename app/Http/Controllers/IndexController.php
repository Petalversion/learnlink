<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Reviews;
use App\Models\toc;
use App\Models\Student_info;
use App\Mail\ContactFormMail;
use App\Models\Instructor_info;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {

        $courses = Course::where('status', 'publish')->take(6)->orderBy('updated_at', 'desc')->get();
        $coursesrandom = Course::where('status', 'publish')->inRandomOrder()->limit(6)->get();
        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();
        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;

        // Calculate average reviews for each course
        $reviewsData = Reviews::select('course_id', \DB::raw('AVG(score) as average_score'), \DB::raw('COUNT(*) as reviewer_count'))
            ->groupBy('course_id')
            ->get();

        // Associate average reviews and reviewer counts with courses
        $coursesWithReviewsData = $courses->map(function ($course) use ($reviewsData) {
            $reviewData = $reviewsData->where('course_id', $course->course_id)->first();
            $course->average_score = $reviewData ? $reviewData->average_score : 0;
            $course->reviewer_count = $reviewData ? $reviewData->reviewer_count : 0;
            return $course;
        });



        $coursesWithReviewsDatarandom = $coursesrandom->map(function ($course) use ($reviewsData) {
            $reviewData = $reviewsData->where('course_id', $course->course_id)->first();
            $course->average_score = $reviewData ? $reviewData->average_score : 0;
            $course->reviewer_count = $reviewData ? $reviewData->reviewer_count : 0;
            return $course;
        });

        return view('landing/index', compact('coursesWithReviewsData', 'coursesWithReviewsDatarandom', 'courses', 'coursesrandom', 'cart', 'user_info', 'instructor_info'));
    }

    public function showInstructorPage()
    {
        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();
        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;

        return view('intsland', compact('cart', 'user_info', 'instructor_info'));
    }
    public function showAboutUsPage()
    {
        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();
        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;

        return view('about-us', compact('cart', 'user_info', 'instructor_info'));
    }

    public function showTCPage()
    {
        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();
        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;

        $toc = toc::first();

        return view('terms-and-condition', compact('cart', 'user_info', 'instructor_info', 'toc'));
    }
    public function showContactUsPage()
    {
        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();
        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;

        return view('contact', compact('cart', 'user_info', 'instructor_info'));
    }

    public function sendContactUsPage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        Mail::to('abellaaaa15@gmail.com')->send(new ContactFormMail($data));

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }


    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search == '' || ctype_space($search)) {
            return redirect()->route('index');
        }

        if ($search) {
            $dataQuery = Course::where('title', 'LIKE', "%{$search}%")
                ->where('status', 'publish');

            if ($request->has('free')) {
                $dataQuery->where('free', 1);
            }

            if ($request->has('paid')) {
                $dataQuery->where('paid', 1);
            }

            if ($request->has('beginner')) {
                $dataQuery->where('difficulty', 'beginner');
            }

            if ($request->has('intermediate')) {
                $dataQuery->where('difficulty', 'intermediate');
            }

            if ($request->has('expert')) {
                $dataQuery->where('difficulty', 'expert');
            }

            $data = $dataQuery->get();
        }


        $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
        $user_info = Student_info::where('student_id', $userId)->first();
        $InstrId = Auth::guard('instructor')->user() ? Auth::guard('instructor')->user()->instructor_id : null;
        $instructor_info = Instructor_info::where('instructor_id', $InstrId)->first();
        $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;

        $reviewsData = Reviews::select('course_id', \DB::raw('AVG(score) as average_score'), \DB::raw('COUNT(*) as reviewer_count'))
            ->groupBy('course_id')
            ->get();

        $coursesWithReviewsData = $data->map(function ($course) use ($reviewsData) {
            $reviewData = $reviewsData->where('course_id', $course->course_id)->first();
            $course->average_score = $reviewData ? $reviewData->average_score : 0;
            $course->reviewer_count = $reviewData ? $reviewData->reviewer_count : 0;
            return $course;
        });

        return view('search', compact('data', 'cart', 'user_info', 'instructor_info', 'coursesWithReviewsData', 'search'));
    }
}
