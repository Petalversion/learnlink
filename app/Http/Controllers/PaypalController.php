<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use CurL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Models\Course;
use App\Models\Transactions;
use App\Models\Cart;
use App\Models\Instructor_wallet;
use App\Models\Student_info;
use Omnipay\Omnipay;

class PaypalController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $transaction_id = $this->generateTransactionId();
                $userId = Auth::guard('student')->user()->student_id;
                $total = Cart::where('student_id', $userId)->sum('amount');
                $cartItems = Cart::where('student_id', $userId)->get();
                $lineItems = [];
                foreach ($cartItems as $cartItem) {
                    foreach ($cartItem->courses as $course) {
                        $lineItems[] = [
                            'course_id' => $course->course_id,
                            'amount' => $course->amount,
                        ];
                    }
                }

                foreach ($cartItems as $cartItem) {
                    foreach ($cartItem->courses as $course) {
                        $wallet = Instructor_wallet::create([
                            'instructor_id' => $course->instructor_id,
                            'course_id' => $course->course_id,
                            'amount' => ((40 / 100) * $course->amount),
                        ]);
                        $wallet->save();
                    }
                }

                $transaction = Transactions::create([
                    'transaction_id' => $transaction_id,
                    'student_id' => $userId,
                    'course_id_amount' => $lineItems,
                    'total_amount' => $total,
                    'type' => 'gcash',
                ]);

                Cart::where('student_id', $userId)->delete();


                return redirect()->route('student.cart')
                    ->with('success', 'Payment Successful');
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Payment Declined!!';
        }
    }

    public function error()
    {
        return 'User declined the Payment!';
    }

    private function generateTransactionId()
    {
        $date_today = date("Ymd");
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 7);
        return 'LL' . $date_today . '-' . $random_string;
    }
}
