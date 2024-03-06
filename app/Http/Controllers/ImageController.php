<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Lesson;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lesson_id' => 'required|exists:lessons,lesson_id',
        ]);

        $lessonId = $request->input('lesson_id');
        $imagePath = $request->file('file')->store('lesson_images', 'public');

        // Create and associate image with the lesson
        $lesson = Lesson::find($lessonId);
        $image = new Image([
            'image_id' => Str::random(9),
            'image_path' => $imagePath, // Save the generated filename
        ]);

        $lesson->images()->save($image);

        return response()->json(['url' => asset('storage/' . $imagePath)]);
    }

}
