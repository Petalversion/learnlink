<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student_info;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Cart;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required',
        ]);
        $course_id = $request->input('course_id');
        // $product = Course::findOrFail($course_id);
        $userId = Auth::user()->student_id; // Get the currently authenticated user's ID


        // Check if the product is already in the cart
        $cartItem = Cart::where('student_id', $userId)->where('course_id', $course_id)->first();
        // dd($cartItem);

        if ($cartItem) {
            // If product exists in the cart, return a message without adding it again
            return redirect()->back()->with('error', 'Course is already in your cart!');
        } else {
            $price = Course::where('course_id', $course_id)->firstOrFail();
            // If item does not exist in cart, add a new entry
            Cart::create([
                'student_id' => $userId,
                'course_id' => $course_id,
                'amount' => $price->amount,
            ]);

            return redirect()->back()->with('success', 'Course added to cart successfully!');
        }
    }

    public function showCart()
    {
        $userId = Auth::user()->student_id;
        $name = Auth::user()->name;
        $user = Auth::user();
        $user_info = Student_info::where('student_id', $user->student_id)->first();
        $cartItems = Cart::where('student_id', $userId)->get();
        $total = Cart::where('student_id', $userId)->sum('amount');
        $courses = [];

        foreach ($cartItems as $cart) {
            $courses[] = $cart->courses;

            // Process courses for each cart
        }

        return view('student.cart', compact('cartItems', 'courses', 'total', 'name', 'user_info'));
    }

    public function removeItem($id)
    {
        // Find the item in the cart
        $cartItem = Cart::findOrFail($id);

        // Delete the item
        $cartItem->delete();

        // Redirect back or to a specific route
        return redirect()->route('student.cart')->with('success', 'Item removed from cart.');
    }
}
