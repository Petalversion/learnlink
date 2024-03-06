<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Course;
use App\Models\Sales;

class CategoryController extends Controller
{
    public function showCategory()
    {
        $categories = Category::all();
        $categories = Course::with(['categories', 'sales'])->get();

        // Pass the data to the view
        return view('instructor.course.category', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('instructor.course.category-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('instructor.course.category-create')->with('success', 'Category created successfully.');
    }

}