@extends('layout.main-side')

@section('content')
<title>{{$name}} - {{$course->title}}</title>

<div class="sidetoppadding">

    <a href="{{ route('instructor.course.course') }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <!-- Page Heading -->

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <div class="container">
                    <h1>Edit Course</h1>
                    <form action="{{ route('instructor.course.update', ['course_id' => $course->course_id]) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
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

                        <input type="hidden" name="course_id" value="{{ session('course_id') }}">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="summary" class="form-label">Summary</label>
                                    <textarea id="summary" name="summary" class="form-control" rows="6" required>{{ old('summary', $course->summary) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Course
                                        Description</label>
                                    <textarea name="description" id="description">{{ old('description', $course->description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="wyl" class="form-label">What You'll
                                        Learn</label>
                                    <textarea name="wyl" id="wyl">{{ old('wyl', $course->wyl) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea name="requirements" id="requirements">{{ old('requirements', $course->requirements) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="container border p-3 mb-3" style="border-radius: 15px;">
                                    <div class="mb-3">
                                        @if ($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" alt="" class="course-img" style="max-width:100%;">
                                        @else
                                        <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" class="course-img" style="max-width: 100%;">
                                        @endif

                                        <label for="image" class="form-label">Change Image</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                </div>

                                <hr>

                                <div class="container border p-3 mb-3" style="border-radius: 15px;">
                                    <div class="mb-1">
                                        <label class="form-label">Difficulty</label><br>
                                        @foreach(['beginner', 'intermediate', 'expert'] as $difficulty)
                                        <div class="col-xl-12 form-check form-check-inline">
                                            <input type="radio" id="{{ $difficulty }}" name="difficulty" class="form-check-input" value="{{ $difficulty }}" {{
                                                                old('difficulty', $course->difficulty) === $difficulty ?
                                                            'checked' : '' }} required>
                                            <label for="{{ $difficulty }}" class="form-check-label">{{
                                                                ucfirst($difficulty) }}</label>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                                <hr>
                                <div class="container border p-3 mb-3" style="border-radius: 15px;">
                                    <div class="mb-3">
                                        <label for="tag" class="form-label">Tag</label>
                                        @foreach ($tags as $tag)
                                        <div class="form-check">
                                            <input type="checkbox" id="tag_{{ $tag->id }}" name="tags[]" class="form-check-input" value="{{ $tag->id }}" {{
                                                                in_array($tag->id, old('tags',
                                                            $course->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label for="tag_{{ $tag->id }}" class="form-check-label">{{
                                                                $tag->name }}</label>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                                <hr>
                                <div class="container border p-3" style="border-radius: 15px;">
                                    <label for="status" class="form-label">Course Status</label>
                                    <select name="status" id="status" class="form-select" {{ $combo == 0 ? 'disabled' : '' }}>
                                        <option value="publish" {{ old('status', $course->status) === 'publish' ? 'selected' : '' }}>Publish</option>
                                        <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>


                                <hr>
                                <div class="container border p-3" style="border-radius: 15px;">
                                    <h7>Course Price</h7>
                                    <div class="mb-3 form-check d-none">
                                        <input type="checkbox" id="paid" name="paid" class="form-check-input" value="1" {{ old('paid',
                                                            $course->paid) ? 'checked' : '' }}>
                                        <label for="paid" class="form-check-label">Paid Course</label>
                                    </div>

                                    <div class="mb-3 form-check d-none">
                                        <input type="hidden" name="free" value="0">
                                        <input type="checkbox" id="free" name="free" class="form-check-input" value="1" {{ old('free',
                                                            $course->free) ? 'checked' : '' }}>
                                        <label for="free" class="form-check-label">Free Course</label>
                                    </div>
                                    <div class="mb-0 mt-2 input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" id="amount" name="amount" class="form-control" step="0.01" placeholder="Course Amount" value="{{ old('amount', isset($course) ? $course->amount : '') }}">
                                    </div>
                                </div>
                                <div class="container p-0 mt-3 mb-3" style="border-radius: 15px;">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <!-- <button type="submit" name="draft" value="1"
                                                    class="btn btn-secondary">Save as Draft</button> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            },

            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            }
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#wyl'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            },

            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            }
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#requirements'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            },

            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection