<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    public function show()
{
    return view('terms-and-condition'); // Assuming you have a blade view file for the terms and conditions
}

}
