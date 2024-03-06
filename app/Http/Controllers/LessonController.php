<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Instructor_info;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;

class LessonController extends Controller
{
    private function generateLessonId()
    {
        return Str::random(9);
    }

    public function create($course_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $courses = Course::where('course_id', $course_id)->get();
            $instructor = Course::where('course_id', $course_id)->get();
            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();
            foreach ($instructor as $user) {
                $uid = $user->instructor->name;
            }

            return view('instructor.lesson.lesson-create', compact('courses', 'uid', 'name', 'instructor_info'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'video_source' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'files' => 'nullable|max:10240',
            'course_id' => 'required|exists:courses,course_id',
        ]);

        // Use the course_id from the form data
        $course_id = $request->input('course_id');

        if ($request->hasFile('video_source')) {
            $request->validate([
                'video_source' => 'required|mimes:mp4,mov,avi|max:10240', // Adjust allowed file types and size
            ]);
            $videoPath = $request->file('video_source')->store('video_source', 'public');
        } else {
            $videoPath = null;
        }

        $uploadedFiles = [];

        if ($request->has('files')) {
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
        }


        // Create the lesson first
        $lesson = Lesson::create([
            'lesson_id' => $this->generateLessonId(),
            'course_id' => $course_id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'video_source' => $videoPath,
            'uploadedFiles' => $uploadedFiles,
        ]);


        return redirect()->route('instructor.course.course-view', ['course_id' => $course_id])
            ->with('success', 'Lesson created');
        // }

    }
    public function uploadImage(Request $request)
    {
        return app(ImageController::class)->upload($request);
    }




    public function destroy($lesson_id)
    {
        // Find the lesson by ID
        $lesson = Lesson::find($lesson_id);

        // Check if the lesson exists
        if (!$lesson) {
            return redirect()->route('instructor.course.course-view', ['course_id' => $lesson->course_id])->with('error', 'Lesson not found');
        }

        // Get the course ID before deleting the lesson
        $courseId = $lesson->course_id;

        // Implement any additional authorization logic if needed (e.g., check if the authenticated user owns the lesson)

        // Delete the lesson
        $lesson->delete();

        // Redirect to the course edit page with the same course_id
        return redirect()->route('instructor.course.course-view', ['course_id' => $courseId])
            ->with('success', 'Lesson has been deleted!');
    }

    public function lessonEdit($lesson_id)
    {
        $status = Auth::guard('instructor')->user()->status;
        if ($status == 'Pending') {
            return redirect('/instructor/profile');
        } else {

            $lesson = Lesson::where('lesson_id', $lesson_id)->first();
            $name = Auth::user()->name;
            $user = Auth::user();
            $instructor_info = Instructor_info::where('instructor_id', $user->instructor_id)->first();

            if (!$lesson) {
                return redirect()->route('instructor.course.course-view')->with('error', 'Lesson not found.');
            }
            return view('instructor.lesson.lesson-edit', compact('lesson', 'name', 'instructor_info'));
        }
    }

    public function update(Request $request, $lesson_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'video_source' => 'nullable|mimes:mp4,mov,avi|max:10240',
            'files' => 'nullable|max:10240'
        ]);

        if ($request->hasFile('video_source')) {
            $request->validate([
                'video_source' => 'required|mimes:mp4,mov,avi|max:10240', // Adjust allowed file types and size
            ]);
            $videoPath = $request->file('video_source')->store('video_source', 'public');
        }

        $uploadedFiles = [];
        if ($request->has('files')) {
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
        }

        $lesson = Lesson::where('lesson_id', $lesson_id)->first();

        if (!$lesson) {
            return redirect()->route('instructor.course.course-view')->with('error', 'Lesson not found.');
        }

        $lesson->title = $request->input('title');
        $lesson->content = $request->input('content');
        if ($request->has('files')) {
            $lesson->uploadedFiles = $uploadedFiles;
        }
        if ($request->hasFile('video_source')) {
            $lesson->video_source = $videoPath;
        }
        $lesson->save();

        return redirect()->route('instructor.lesson.lesson-edit', ['lesson_id' => $lesson->lesson_id])->with('success', 'Lesson updated successfully.');
    }
}
