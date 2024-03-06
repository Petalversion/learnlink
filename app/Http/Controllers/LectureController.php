<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Lecture;
use App\Models\Course;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;

class LectureController extends Controller
{
    private function generateLectureId()
    {
        return Str::random(9);
    }

    public function create($lesson_id)
    {
        $lessons = Lesson::where('lesson_id', $lesson_id)->get();

        return view('instructor.lecture.lecture-create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'video_source' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'lesson_id' => 'required|exists:lessons,lesson_id',
            'files' => 'nullable|max:10240'
            // 'status' => 'required|in:draft,publish',
        ]);

        $lesson_id = $request->input('lesson_id');

        if ($request->hasFile('video_source')) {
            $request->validate([
                'video_source' => 'required|mimes:mp4,mov,avi|max:10240', // Adjust allowed file types and size
            ]);
            $videoPath = $request->file('video_source')->store('video_source', 'public');
        } else {
            $videoPath = null;
        }

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(20) . '.' . $extension;

            // Determine the storage path based on the file type
            $storagePath = $extension === 'pdf' ? 'pdfs' : 'zips';
            // $maxUploadSize = ini_get('upload_max_filesize');
            // dd($maxUploadSize);
            // Store the file
            $path = $file->storeAs('public/' . $storagePath, $fileName);

            // Add file information to the array
            $uploadedFiles[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'type' => $extension,
            ];
        }

        // Create the lesson first
        $lesson = Lecture::create([
            'lecture_id' => $this->generateLectureId(),
            'lesson_id' => $lesson_id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'video_source' => $videoPath,
            'uploadedFiles' => $uploadedFiles,
        ]);

        // Handle image uploads

        return redirect()->route('instructor.lesson.lesson-view', ['lesson_id' => $lesson_id])
            ->with('success', 'Lecture Successfully Added!');
    }
    public function uploadImage(Request $request)
    {
        return app(ImageController::class)->upload($request);
    }




    public function destroy($lecture_id)
    {
        // Find the lesson by ID
        $lecture = Lecture::find($lecture_id);

        // Check if the lesson exists
        if (!$lecture) {
            return redirect()->route('instructor.lesson.lesson-view', ['lesson_id' => $lecture->lesson_id])->with('error', 'Lecture does not exist!');
        }

        // Get the course ID before deleting the lesson
        $lesson_id = $lecture->lesson_id;

        // Implement any additional authorization logic if needed (e.g., check if the authenticated user owns the lesson)

        // Delete the lesson
        $lecture->delete();

        // Redirect to the course edit page with the same course_id
        return redirect()->route('instructor.lesson.lesson-view', ['lesson_id' => $lesson_id])
            ->with('success', 'Lecture has been deleted!');
    }


}