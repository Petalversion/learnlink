<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Reviews;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Instructor;
use App\Models\Instructor_wallet;
use App\Models\Transactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;



class AdminController extends Controller
{
    public function updateWithdrawalRequest(Request $request)
    {
        $requestId = $request->input('request_id');
        $referenceId = $request->input('reference_id');
        $transaction = Instructor_wallet::where('request_id', $requestId)->first();
        $transaction->reference_id = $referenceId;
        $transaction->save();

        return redirect()->back()->with('success', 'Receipt Number<strong> ' . $referenceId . '</strong> was added to Request <strong>' . $requestId . '</strong>');
    }

    public function updateStatus(Request $request)
    {
        $instructorId = $request->input('instructor_id');
        // Find the instructor by ID and update the status
        $instructor = Instructor::find($instructorId);
        $instructor->status = $request->input('type');; // Change this according to your logic
        $instructor->save();

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function showRegistrationForm()
    {
        if (Auth::guard('instructor')->check()) {
            return redirect()->route('instructor.dashboard');
        } elseif (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        $name = Auth::user()->name;
        $user = Auth::user();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.users.register', compact('name', 'withdrawalRequest', 'pendingInstructor')); // Return the view for the registration form
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new admin user and store in the 'admin_users' table
        $admin = new Admin;
        $admin->admin_id = Str::random(9);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->role = 'admin';
        $admin->save();

        // Redirect to a success page or login page
        return redirect()->route('admin.admin')->with('success', 'Admin Account Created Successfully!');
    }

    public function showLoginForm()
    {

        if (Auth::guard('instructor')->check()) {
            return redirect()->route('instructor.dashboard');
        } elseif (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validation logic for login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the admin
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication success, redirect to admin dashboard or any other page
            return redirect()->route('admin.dashboard');
        }

        // Authentication failed, redirect back with an error message
        return redirect('/')->with('error', 'Invalid credentials. Please try again.');
    }

    public function logout()
    {
        Auth::logout(); // Log the admin out
        return redirect()->route('index');
    }

    public function showAdminDashboard()
    {
        $name = Auth::user()->name;
        $user = Auth::user();

        $students = Student::all();
        $instructors = Instructor::where('status', 'approved')->get();
        $courses = Course::where('status', 'publish')->get();
        $instructor_wallets = Instructor_wallet::all();

        $amounts = array_fill(0, 12, 0); // Initialize with 0 for each month
        $instructorAmount = array_fill(0, 12, 0);
        $adminAmount = array_fill(0, 12, 0);
        $allCourses = count($courses);
        $allStudents = count($students);
        $allInstructors = count($instructors);
        // Retrieve wallet data for the current year
        $currentYear = Carbon::now()->year;
        $transactions = Transactions::whereYear('created_at', $currentYear)->where('total_amount', '>=', 0)->get();

        // Loop through wallet data and accumulate amounts for each month
        foreach ($transactions as $transaction) {
            $month = Carbon::parse($transaction->created_at)->month;
            $amounts[$month - 1] += $transaction->total_amount; // Subtract 1 to match array index
            $instructorAmount[$month - 1] += $transaction->total_amount * 0.4;
            $adminAmount[$month - 1] += $transaction->total_amount * 0.6;
        }
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();

        return view('admin.dashboard', compact('name', 'user', 'amounts', 'instructorAmount', 'adminAmount', 'allCourses', 'allInstructors', 'allStudents', 'withdrawalRequest', 'pendingInstructor'));
    }

    public function showInstructorList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $instructors = Instructor::all();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.users.instructor', compact('name', 'instructors', 'withdrawalRequest', 'pendingInstructor'));
    }

    public function showCourseList($instructor_id)
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $instructor = Instructor::where('id', $instructor_id)->first();
        $courses = Course::where('instructor_id', $instructor->instructor_id)->where('status', 'publish')->get();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.users.course', compact('name', 'withdrawalRequest', 'pendingInstructor', 'courses'));
    }

    public function showCourseLesson($course_id)
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $course = Course::where('id', $course_id)->first();
        $instructor = Instructor::where('instructor_id', $course->instructor_id)->first();
        $lessons = Lesson::where('course_id', $course->course_id)->get();
        $quizzes = Exam::where('course_id', $course->course_id)->get();

        $course_rating = Reviews::where('course_id', $course->course_id)->get();
        $rounded_rating = round($course_rating->avg('score'), 1);
        $course_count = count($course_rating);

        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.users.lesson', compact('name', 'withdrawalRequest', 'pendingInstructor', 'course', 'lessons', 'quizzes', 'course_count', 'rounded_rating', 'instructor'));
    }

    public function showAdminList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $admins = Admin::all();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.users.admin', compact('name', 'admins', 'withdrawalRequest', 'pendingInstructor'));
    }

    public function showStudentList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $students = Student::all();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.users.student', compact('name', 'students', 'withdrawalRequest', 'pendingInstructor'));
    }

    public function showTransactionList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $transactions = Transactions::whereNotNull('total_amount')->get();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.transactions', compact('name', 'transactions', 'withdrawalRequest', 'pendingInstructor'));
    }

    public function showWithdrawalRequestList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $transactions = Instructor_wallet::whereNotNull('request_id')->get();
        $pendingInstructor = Instructor::where('status', 'pending')->count();
        $withdrawalRequest = Instructor_wallet::where('amount', '<', 0)->whereNull('reference_id')->count();
        return view('admin.withdrawal-request', compact('name', 'transactions', 'withdrawalRequest', 'pendingInstructor'));
    }

    // Define other admin-specific actions or methods as needed
}
