@extends('layout.main-side')

@section('content')


<div class="sidetoppadding">

    <a href="{{ route('instructor.course.course-view', ['course_id' => $lesson->course->id]) }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>

    <!-- Page Heading -->

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <div class="container mt-2">
                    <h1 class="mb-4">Edit Lesson</h1>


                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif


                    <form action="{{ route('instructor.lesson.update', ['lesson_id' => $lesson->lesson_id]) }}" method="POST" enctype="multipart/form-data" id="myForm">
                        @csrf
                        @method('PUT')

                        <!-- Hidden input for course_id -->
                        <input type="hidden" name="lesson_id" value="{{ $lesson->course_id }}">

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $lesson->title) }}">
                        </div>
                        <div class="mb-3">
                            <div id="toolbar-container"></div>
                            <div id="editor">
                                {!! $lesson->content !!}
                            </div>
                            <textarea style='display:none;' name='content' id='contentInput'></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="files" class="form-label">Files Source (max Size
                                10MB)</label>
                            <input id="files" type="file" name="files[]" class="form-control" accept=".pdf, .zip" multiple>
                        </div>
                        <div class="mb-3">
                            Files Currently Attached
                            <li class="text-left">
                                @if (!empty($lesson->uploadedFiles))
                                @foreach ($lesson->uploadedFiles as $file)
                                @if (is_array($file) && isset($file['name']))
                                {{ htmlspecialchars($file['name']) }}<br>
                                @endif
                                @endforeach
                                @else
                                No files uploaded
                                @endif
                            </li>
                        </div>

                        <div class=" mb-3">
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

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/decoupled-document/ckeditor.js"></script>
<script>
    DecoupledEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            },
        })
        .then(editor => {
            const toolbarContainer = document.querySelector('#toolbar-container');

            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    document.getElementById("myForm").addEventListener("submit", function(event) {
        var htmlContent = document.getElementById("editor").innerHTML;
        document.getElementById("contentInput").value = htmlContent;
    });
</script>
@endsection