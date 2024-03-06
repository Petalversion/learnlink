@extends('layout.master')

@section('content')
<div class="container">
    <h1>Create Tag</h1>
    <form action="{{ route('instructor.course.tags.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tag Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Tag</button>
    </form>
</div>
@endsection
