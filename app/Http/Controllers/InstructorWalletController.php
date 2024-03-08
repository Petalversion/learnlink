<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Questions;
use App\Models\Instructor_wallet;
use App\Models\Instructor_info;

class InstructorWalletController extends Controller
{
    public function showTransactions()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            $balance = Instructor_wallet::where('instructor_id', $user->instructor_id)->sum('amount');

            $withdrawals = Instructor_wallet::where('instructor_id', $user->instructor_id)->whereNotNull('request_id')->get();

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

            return view('instructor.withdrawal.transactions', compact('name', 'instructor_info', 'balance', 'withdrawals', 'questionNotif'));
        }
    }

    public function newTransactions()
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            $balance = Instructor_wallet::where('instructor_id', $user->instructor_id)->sum('amount');

            $withdrawals = Instructor_wallet::where('instructor_id', $user->instructor_id)->whereNotNull('request_id')->get();

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

            return view('instructor.withdrawal.new-transactions', compact('name', 'instructor_info', 'balance', 'withdrawals', 'questionNotif'));
        }
    }

    public function addTransactions(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'instructor_id' => 'required',
                'payment' => 'required',
                'amount' => 'numeric|gte:200',
            ]);

            $answer = Instructor_wallet::create([
                'instructor_id' => $validatedData['instructor_id'],
                'type' => $validatedData['payment'],
                'amount' => -$validatedData['amount'],
                'request_id' => $this->generateRequestId(),
            ]);

            return redirect()->route('instructor.transactions')->with('success', 'Withdrawal request sent! Please wait for Approval!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    private function generateRequestId()
    {
        return 'LL-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
    }
}
