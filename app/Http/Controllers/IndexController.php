<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Instructor;
use App\Models\Reviews;
use App\Models\toc;
use App\Models\Student_info;
use App\Models\Transactions;
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
            $dataQuery = Course::where('status', 'publish')
                ->where(function ($query) use ($search) {
                    $query->whereRaw('JSON_CONTAINS(tags, ?)', ["\"$search\""])
                        ->orWhere('title', 'LIKE', "%{$search}%")
                        ->orWhereHas('instructor', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                });


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

            if ($request->has('category')) {
                $dataQuery->where('category', $request->input('category'));
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

        $categories = Category::all();

        return view('search', compact('data', 'cart', 'user_info', 'instructor_info', 'coursesWithReviewsData', 'search', 'categories'));
    }

    public function showInstructorInfoPage($id)
    {


        $instr = Instructor::where('id', $id)->first();
        if ($instr) {
            $data = Course::where('instructor_id', $instr->instructor_id)->where('status', 'publish')->get();
            $instr_info = Instructor_info::where('instructor_id', $instr->instructor_id)->first();


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

            $categories = Category::all();

            $instructor_courses = Course::where('status', 'publish')->where('instructor_id', $instr->instructor_id)->get();

            $totalCourses = count($instructor_courses);

            $courseIds = Course::where('instructor_id', $instr->instructor_id)->pluck('course_id');

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

            return view('instructor_info', compact('data', 'cart', 'user_info', 'instructor_info', 'coursesWithReviewsData', 'instr_info', 'instr',  'totalCourses', 'totalStudents', 'totalReviews', 'totalAverageReviews'));
        }
        return redirect()->route('index');
    }
}
