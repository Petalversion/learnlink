<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Instructor_wallet;
use App\Models\Transactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



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
        return view('Design/register'); // Return the view for the registration form
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
        return redirect('/');
    }

    public function showLoginForm()
    {

        if (Auth::guard('instructor')->check()) {
            return redirect('/instructor/dashboard');
        } elseif (Auth::guard('student')->check()) {
            return redirect('/student/dashboard');
        } elseif (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        return view('admin_login');
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
            return redirect('/admin/dashboard');
        }

        // Authentication failed, redirect back with an error message
        return redirect('/')->with('error', 'Invalid credentials. Please try again.');
    }

    public function logout()
    {
        Auth::logout(); // Log the admin out
        return redirect('/');
    }

    public function showAdminDashboard()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        return view('admin.dashboard', compact('name', 'user'));
    }

    public function showInstructorProfile()
    {
        return view('/Design/instructor');
    }

    public function showUserProfile()
    {
        return view('/Design/user');
    }


    public function showInstructorList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $instructors = Instructor::all();
        return view('admin.users.instructor', compact('name', 'instructors'));
    }

    public function showStudentList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $students = Student::all();
        return view('admin.users.student', compact('name', 'students'));
    }

    public function showTransactionList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $transactions = Transactions::all();
        return view('admin.transactions', compact('name', 'transactions'));
    }

    public function showWithdrawalRequestList()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $transactions = Instructor_wallet::whereNotNull('request_id')->get();
        return view('admin.withdrawal-request', compact('name', 'transactions'));
    }

    // Define other admin-specific actions or methods as needed
}
