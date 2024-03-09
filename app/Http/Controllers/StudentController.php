<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Course;
use App\Models\Cart;
use App\Models\Lesson;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\QuizAttemptCounter;
use App\Models\Reviews;
use App\Models\Student_info;
use App\Models\Transactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Question\Question;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::guard('instructor')->check()) {
            return redirect()->route('instructor.dashboard');
        } elseif (Auth::guard('student')->check()) {
            return redirect()->route('student.profile');
        }
        return view('student.register'); // Return the view for the registration form
    }

    public function showCertificates()
    {
        $userId = Auth::user()->student_id;
        $name = Auth::user()->name;
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();
        $certificates = QuizAttemptCounter::where('student_id', $user->student_id)->get();

        return view('student.certificates', compact('name', 'user_info', 'certificates')); // Return the view for the registration form
    }

    public function showStudentCourses()
    {
        $userId = Auth::user()->student_id;
        $name = Auth::user()->name;
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();
        $courses = Transactions::where('student_id', $userId)->get();
        $courseIds = $courses->flatMap(function ($transaction) {
            return collect($transaction->course_id_amount)->pluck('course_id');
        })->unique();
        $courseinfo = [];

        foreach ($courseIds as $courseId) {
            $courseData = Course::where('course_id', $courseId)->first();
            if ($courseData !== null) {
                $courseinfo[] = $courseData;

                // Retrieve the first lesson associated with the current course
                $lessonData = Lesson::where('course_id', $courseData->course_id)->first();

                if ($lessonData !== null) {
                    // Store the first lesson data
                    $courseData->first_lesson = $lessonData;
                }
            }
        }
        // dd($courseinfo);

        return view('student.courses', compact('userId', 'courseinfo', 'name', 'user_info')); // Return the view for the registration form
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student_users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student_users',
            'password' => 'required|string|min:6|confirmed',
            'termsCheckbox' => 'required|accepted', // Ensure the checkbox is checked
        ]);

        try {
            $student_id = Str::random(9);
            // Create a new student user and store in the 'students' table
            $student = new Student;
            $student->student_id = $student_id;
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->password = Hash::make($request->input('password'));
            $student->role = 'student';
            $student->save();

            $info = new Student_info;
            $info->student_id = $student_id;
            $info->paypal = $request->input('email');
            $info->save();

            if (Auth::guard('student')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                // Authentication success, redirect to dashboard or any other page
                return redirect()->route('student.profile');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // If a database exception occurs (e.g., email uniqueness constraint violation), redirect back with error message
            return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
        }
    }

    // Show the login form
    public function showLoginForm()
    {
        if (Auth::guard('instructor')->check()) {
            return redirect()->route('instructor.dashboard');
        } elseif (Auth::guard('student')->check()) {
            return redirect()->route('student.profile');
        }
        return view('student.login');
    }

    public function showLearn($course_id, $lesson_id)
    {

        $course = Course::where('course_id', $course_id)->first();
        if ($course) {
            $lesson = Lesson::where('lesson_id', $lesson_id)->first();
            if ($lesson) {
                $userId = Auth::guard('student')->user() ? Auth::guard('student')->user()->student_id : null;
                $user = Auth::user();
                $user_info = Student_info::where('student_id', $user->student_id)->first();
                $cart = $userId ? Cart::where('student_id', $userId)->count() : 0;
                $name = Auth::user()->name;

                $student = Student::get();
                $student_info = Student_info::get();
                $student_comment = Questions::where('lesson_id', $lesson->lesson_id)->get();
                $instructor_comment = Answers::where('comment_id', $lesson->lesson_id)->get();
                $course_reviews = Reviews::where('course_id', $course_id)->whereNotIn('student_id', [$user->student_id])->get();
                $student_review = Reviews::where('course_id', $course_id)->where('student_id', $user->student_id)->first();



                if (!$course) {
                    return redirect()->route('student.profile')->with('error', 'Course not found.');
                }

                return view('student.learn', compact('course', 'lesson', 'cart', 'name', 'user_info', 'student_comment', 'instructor_comment', 'user', 'course_reviews', 'student_review'));
            }
            return redirect()->route('student.courses');
        }
        return redirect()->route('student.courses');
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

        if (Auth::guard('student')->attempt($credentials)) {
            // Authentication success, redirect to student dashboard or any other page
            return redirect()->route('student.profile');
        }

        // If login fails, redirect back with an error message
        return redirect()->route('student.login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    // Define other student-specific actions or methods as needed

    public function exam(Request $request, $course_id)
    {

        // Assuming you have a Question model representing your questions table
        $name = Auth::user()->name;
        $questions = Exam::where('course_id', $course_id)->get();
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();

        if ($questions) {

            // Initialize an empty array to hold the formatted questions
            $formattedQuestions = [];

            foreach ($questions as $question) {
                // Format each question into the desired structure
                $options = $question->choices;

                $formattedQuestion = [
                    'numb' => $question->id, // Assuming 'id' is the primary key of the questions table
                    'question' => $question->question, // Assuming 'question_text' is the column containing the question text
                    'answer' => $question->answer, // Assuming 'correct_answer' is the column containing the correct answer
                    'options' => $question->choices
                ];

                // Add the formatted question to the array
                $formattedQuestions[] = $formattedQuestion;
            }

            // Convert the formatted questions array to JSON
            $jsonFormattedQuestions = json_encode($formattedQuestions);

            // Get only the courses created by the current instructor
            $exams = Exam::where('course_id', $course_id)->get();
            $count = Exam::where('course_id', $course_id)->count();
            $header = Course::where('course_id', $course_id)->get();
            $courses = Course::where('course_id', $course_id)->first();
            if ($courses) {
                $coursex = $courses->course_id;
                $attempts = QuizAttemptCounter::where('student_id', $user->student_id)->where('course_id', $coursex)->first();
                $remainingTime = '';
                $attempt = '';
                if ($attempts) {
                    $attempt = $attempts->attempt;
                    $attempttimer = Carbon::parse($attempts->updated_at);
                    // Get the current time
                    $currentDateTime = Carbon::now();

                    // Calculate the difference in minutes
                    $timeDifferenceInMinutes = $currentDateTime->diffInMinutes($attempttimer);

                    // Calculate remaining hours and minutes until 24 hours
                    $hoursRemaining = floor((24 * 60 - $timeDifferenceInMinutes) / 60); // Convert remaining minutes to hours
                    $minutesRemaining = (24 * 60 - $timeDifferenceInMinutes) % 60;

                    $remainingTime = '';
                    if ($hoursRemaining > 0) {
                        $remainingTime .= $hoursRemaining . ' hour' . ($hoursRemaining > 1 ? 's' : '');
                    }
                    if ($minutesRemaining > 0) {
                        $remainingTime .= ($hoursRemaining > 0 ? ' and ' : '') . $minutesRemaining . ' minute' . ($minutesRemaining > 1 ? 's' : '');
                    }
                }
                return view('student.examination', compact('exams', 'count', 'jsonFormattedQuestions', 'header', 'name', 'user_info', 'coursex', 'remainingTime', 'attempt'));
            }
        }
        return redirect()->route('student.courses');
    }


    public function profile(Request $request)
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();

        return view('student.profile', compact('name', 'user', 'user_info'));
    }

    public function profileUpdate(Request $request)
    {
        $name = Auth::user()->name;
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // 'bio' => 'nullable',
            'paypal' => 'nullable|email',
            'gcash' => 'nullable|regex:/^[0-9]{10,}$/',
        ]);
        $student_info = Student_info::where('student_id', $user->student_id)->first();
        $student_name = Student::where('student_id', $user->student_id)->first();
        $student_name->name = $request->input('name');
        // $student_info->bio = $request->input('bio');
        $student_info->gcash = $request->input('gcash');
        $student_info->paypal = $request->input('paypal');

        if ($request->hasFile('profile_picture')) {
            // Add logic to store and handle the uploaded image
            $profile_picture = $request->file('profile_picture')->store('profile_picture', 'public');
            $validatedData['profile_picture'] = $profile_picture;
            $student_info->profile_picture = $profile_picture;
        }

        $student_info->save();
        $student_name->save();

        return redirect()->route('student.profile', compact('name', 'user'))->with('success', 'Information updated successfully.');
    }

    public function history()
    {
        $name = Auth::user()->name;
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();
        $transactions = Transactions::where('student_id', $user->student_id)->get();

        // foreach ($transactions as $transaction) {
        //     foreach ($transaction->course_id_amount as $courseDetail) {
        //         $courseId = $courseDetail['course_id'];
        //         $course = Course::find($courseId);
        //         // if ($course) {
        //         //     $title = $course->title;
        //         // }
        //     }
        // }


        return view('student.purchase-history', compact('name', 'user_info', 'transactions'));
    }

    public function success($course_id)
    {
        $userId = Auth::guard('student')->user()->student_id;
        $courseItems = Course::where('course_id', $course_id)->first();
        $transaction_id = $this->generateTransactionId();

        $lineItems[] = [
            'course_id' => $courseItems->course_id,
            'amount' => $courseItems->amount,
        ];

        $transaction = Transactions::create([
            'transaction_id' => $transaction_id,
            'student_id' => $userId,
            'course_id_amount' => $lineItems,
            'total_amount' => $courseItems->amount,
        ]);

        return redirect()->route('student.courses')->with('success', 'Course Added Successfully');
    }

    private function generateTransactionId()
    {
        $date_today = date("Ymd");
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 7);
        return 'LL' . $date_today . '-' . $random_string;
    }
}
