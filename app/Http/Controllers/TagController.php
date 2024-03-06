<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tag;
use App\Models\Course;

class TagController extends Controller
{
    public function create()
    {
        $tags = Tag::all();
        return view('instructor.course.tags-create', compact('tags'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Tag::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('instructor.course.tags-create')->with('success', 'Tag created successfully.');
    }

    public function show()
    {
        // Get all courses with tags and sales relationship
        $courses = Course::with(['tags', 'sales'])->get();

        return view('instructor.course.tags', compact('courses'));
    }

}
