<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Reviews;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Instructor_info;
use App\Models\Instructor_wallet;
use App\Models\Transactions;

class InstructorController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::guard('instructor')->check()) {
            $status = Auth::guard('instructor')->user()->status;
            if ($status == 'Pending') {
                redirect()->route('instructor.profile');
            } else {
                return redirect()->route('instructor.dashboard');
            }
        } elseif (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }

        return view('instructor.register'); // Return the view for the registration form
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:instructor_users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    // In your InstructorController.php
    public function show()
    {
        return view('terms-and-condition'); // Adjust the view name accordingly
    }


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:instructor_users',
            'password' => 'required|string|min:6|confirmed',
            'termsCheckbox' => 'required|accepted', // Ensure the checkbox is checked
        ]);
        try {
            $instructor_id = Str::random(9);

            $instructor = new Instructor;
            $instructor->instructor_id = $instructor_id;
            $instructor->name = $request->input('name');
            $instructor->email = $request->input('email');
            $instructor->password = Hash::make($request->input('password'));
            $instructor->role = 'instructor';
            $instructor->status = 'pending';
            $instructor->save();

            $info = new Instructor_info;
            $info->instructor_id = $instructor_id;
            $info->paypal = $request->input('email');
            $info->save();

            if (Auth::guard('instructor')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                // Authentication success, redirect to dashboard or any other page
                return redirect()->route('instructor.profile');
            } // Redirect to the instructor login page
        } catch (\Illuminate\Database\QueryException $e) {
            // If a database exception occurs (e.g., email uniqueness constraint violation), redirect back with error message
            return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
        }
    }

    // Show the login form
    public function showLoginForm()
    {
        if (Auth::guard('instructor')->check()) {
            $status = Auth::guard('instructor')->user()->status;
            if ($status == 'Pending') {
                return redirect()->route('instructor.profile');
            } else {
                return redirect()->route('instructor.dashboard');
            }
        } elseif (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }

        return view('instructor.login');
    }

    // Handle the login request
    public function login(Request $request)
    {

        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::guard('instructor')->attempt($credentials)) {
            // Authentication success, redirect to admin dashboard or any other page
            return redirect()->route('instructor.dashboard');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    // Logout the instructor
    public function logout()
    {
        Auth::guard('instructor')->logout();

        return redirect()->route('index'); // Redirect to the home page or login page
    }
    // Instructor Dashboard
    // Show the instructor dashboard
    public function showInstructorDashboard()
    {
        $name = Auth::guard('instructor')->user()->name;
        $user = Auth::guard('instructor')->user();
        $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
        $instructor = Auth::guard('instructor')->user();
        $courses = Course::where('instructor_id', $instructor->instructor_id)->paginate(10);

        $courseIds = $instructor->courses->pluck('course_id');
        $reviews = Reviews::whereIn('course_id', $courseIds)->get();

        $transactions = Transactions::where(function ($query) use ($courseIds) {
            foreach ($courseIds as $courseId) {
                $query->orWhereJsonContains('course_id_amount', [['course_id' => $courseId]]);
            }
        })->get();


        $data = $transactions->map(function ($transaction) {
            return collect($transaction->course_id_amount)->map(function ($item) {
                return [
                    'course_id' => $item['course_id'],
                    'amount' => $item['amount'],
                ];
            })->toArray();
        })->flatten()->toArray();

        $labels = [];
        $amounts = [];

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
        $courseTitles = $instructor->courses->pluck('title');
        $totalEarnings = 0;
        foreach ($courseIds as $courseId) {
            // Retrieve total earnings for each course ID
            $earnings = Instructor_wallet::where('course_id', $courseId)->where('amount', '>=', 0)->sum('amount');

            // Store the total earnings for the current course ID
            $totalEarnings += $earnings;
        }

        $totalEarningsFormatted = '₱ ' . number_format($totalEarnings, 2, '.', ',');
        $totalCourses = count($courseTitles);

        $totalStudents = array_sum($courseCounts);


        return view('instructor.dashboard', compact('instructor', 'courses', 'name', 'user', 'instructor_info', 'amounts', 'labels', 'courseIds', 'courseCounts', 'courseTitles', 'totalEarningsFormatted', 'totalCourses', 'reviews', 'totalStudents'));
    }

    public function profile(Request $request)
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();

        return view('instructor.profile', compact('name', 'user', 'instructor_info'));
    }

    public function profileUpdate(Request $request)
    {
        $name = Auth::user()->name;
        $user = Auth::user();

        // Validating the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable',
            'paypal' => 'nullable|email',
            'gcash' => 'nullable|regex:/^\d{0,10}$/',
        ]);

        try {
            // Retrieving instructor information
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->firstOrFail();
            $instructor_name = Instructor::where('instructor_id', $user->instructor_id)->firstOrFail();

            // Updating the instructor information with validated data
            $instructor_name->name = $validatedData['name'];
            $instructor_info->bio = $validatedData['bio'];
            $instructor_info->gcash = $validatedData['gcash'];
            $instructor_info->paypal = $validatedData['paypal'];

            // Handling profile picture upload
            if ($request->hasFile('profile_picture')) {
                $profile_picture = $request->file('profile_picture')->store('profile_picture', 'public');
                $instructor_info->profile_picture = $profile_picture;
            }

            // Saving the updated instructor information
            $instructor_info->save();
            $instructor_name->save();

            // Redirecting back to instructor profile with success message
            return redirect()->route('instructor.profile', compact('name', 'user'))->with('success', 'Information updated successfully.');
        } catch (\Exception $e) {
            // Redirecting back with error message if an exception occurs
            return redirect()->back()->with('error', 'Failed to update information. Please try again.');
        }
    }
}
