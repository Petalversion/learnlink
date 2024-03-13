@extends('layout.main-side')

@section('content')
<title>{{$name}} - My Courses</title>

<div class="sidetoppadding">
    <div class="row">

        <div class="col-md-12 text-md-right mb-2">
            <a href="{{ route('instructor.course.course-create') }}" class="btn btn-primary btn-icon-split p-0"><span class="icon text-white-50 "><i class="fas fa-plus"></i></span><span class="text">Course</span></a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid mt-2" style="max-width: 100%; overflow-x: auto;">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <table class="table table-striped table-bordered" id="myTable12345">
                    <thead>
                        <tr class="text-center">
                            <th>Title</th>
                            <th>Difficulty </th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h2 style="margin-bottom: 2%;"><i class="fa-solid fa-book"></i> Courses</h2>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{$course->title}}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{$course->difficulty == 'beginner' ? 'badge-beginner' : ($course->difficulty == 'intermediate' ? 'badge-intermediate' : 'badge-expert')}}">
                                    {{$course->difficulty}}
                                </span>
                            </td>
                            <td>{{ $course->paid == 1 ? 'Paid' : 'Free' }}</td>
                            <td class="text-end">{{ $course->paid == 1 ? '₱' . ' ' .
                                                        number_format($course->amount, 2) : 'Free' }}</td>
                            <td>{{$course->status}}</td>
                            <td>
                                <a href="{{ route('instructor.course.course-edit', ['course_id' => $course->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('instructor.course.course-view', ['course_id' => $course->id]) }}" class="btn btn-outline-success"><i class="fas fa-eye "></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection