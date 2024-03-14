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


class PaymentController extends Controller
{


    public function pay()
    {
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();

        $cancel_url = route('student.cart');
        $transaction_id = $this->generateTransactionId();
        $success_url = route('gcash.success', ['transaction_id' => $transaction_id]);
        $authKey = env('AUTH_PAY');
        $userId = Auth::guard('student')->user()->student_id;
        $cartItems = Cart::where('student_id', $userId)->get();
        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            foreach ($cartItem->courses as $course) {
                $lineItems[] = [
                    'currency' => 'PHP',
                    'amount' => intval(($course->amount) * 100),
                    'name' => $course->title,
                    'quantity' => 1
                ];
            }
        }

        $data = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user_info->gcash
                    ],
                    'send_email_receipt' => true,
                    'show_description' => false,
                    'show_line_items' => true,
                    'cancel_url' => $cancel_url,
                    'line_items' => $lineItems,
                    'reference_number' => $transaction_id,
                    'success_url' => $success_url,
                    'statement_descriptor' => 'string',
                    'payment_method_types' => [
                        'gcash'
                    ]
                ]
            ]
        ];

        $client = new Client();

        $response = $client->post('https://api.paymongo.com/v1/checkout_sessions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . $authKey,
            ],
            'json' => $data,
        ]);

        $body = $response->getBody()->getContents();
        $data = json_decode($body);

        // \Session::put('session_id', $data->data->id);
        session()->put('transaction_id', $transaction_id);

        return redirect()->to($data->data->attributes->checkout_url);
    }

    public function success($transaction_id)
    {
        $check_transaction = Transactions::where('transaction_id', $transaction_id)->first();
        if ($check_transaction) {
            return view('thankyou');
        } else {
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


            return view('thankyou');
        }
    }



    private function generateTransactionId()
    {
        $date_today = date("Ymd");
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 7);
        return 'LL' . $date_today . '-' . $random_string;
    }
}
