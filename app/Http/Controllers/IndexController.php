<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Student_info;
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
        return view('landing/index', compact('courses', 'coursesrandom', 'cart', 'user_info', 'instructor_info'));
    }
}
