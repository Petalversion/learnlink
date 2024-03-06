@extends('layout.master')

@section('content')
<div class="container">
    <h1>Create Category</h1>
    <form action="{{ route('instructor.course.category.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
@endsection
