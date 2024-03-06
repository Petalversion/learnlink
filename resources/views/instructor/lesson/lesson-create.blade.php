@extends('layout.main-side')

@section('content')


<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">
    @foreach ($courses as $lesson)
    <a href="{{ route('instructor.course.course-view', ['course_id' => $lesson->course_id]) }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    @endforeach
    <!-- Page Heading -->

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <div class="container mt-2">
                    <h1 class="mb-4">Create Lesson</h1>


                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <form action="{{ route('instructor.lesson.lesson-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($courses as $lesson)
                        <!-- Hidden input for course_id -->
                        <input type="hidden" name="course_id" value="{{ $lesson->course_id }}">

                        <div class="mb-3">
                            <label for="lesson_title" class="form-label">Lesson Title</label>

                            <input type="text" id="course_title" class="form-control" value="{{ $lesson->title }}" readonly>
                        </div>
                        @endforeach
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <textarea name="content" id="editor">
                                        </textarea>


                        <div class="mb-3">
                            <label for="files" class="form-label">Files Source (max Size 10MB)</label>
                            <input id="files" type="file" name="files[]" class="form-control" accept=".pdf, .zip" multiple>
                        </div>

                        <div class="mb-3">
                            <label for="video_source" class="form-label">Video Source (max Size
                                10MB)</label>
                            <input type="file" id="video_source" name="video_source" class="form-control" accept=".mp4, .mov, .avi">
                        </div>

                        <div class="mb-3">
                            <button type="submit" name="status" class="btn btn-primary">Submit</button>
                            <!-- <button type="submit" name="status" value="draft"
                                                class="btn btn-secondary">Save as Draft</button> -->
                        </div>
                    </form>
                    <!-- Include CKEditor library -->

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>