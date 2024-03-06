<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Instructor;
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

            return view('instructor.withdrawal.transactions', compact('name', 'instructor_info', 'balance', 'withdrawals'));
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

            return view('instructor.withdrawal.new-transactions', compact('name', 'instructor_info', 'balance', 'withdrawals'));
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

            return redirect()->route('instructor.transactions')->with('success', 'Transaction successful');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    private function generateRequestId()
    {
        return 'LL-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
    }
}
