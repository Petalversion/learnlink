@extends('layout.main-side')

@section('content')
<div class="sidetoppadding">
    <a href="{{ route('admin.instructor') }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid mt-2" style="max-width: 100%; overflow-x: auto;">
                <table class="table table-striped table-bordered" id="myTable12345">
                    <thead>
                        <tr class="text-center">
                            <th>Title</th>
                            <th>Difficulty </th>
                            <th>Type</th>
                            <th>Price</th>
                            <th class="text-center">Actions</th>
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
                            <td class="text-center">
                                <button type="button" onclick="window.location='{{ route('instructor.course.course-view', ['course_id' => $course->id]) }}'" class=" badge badge-pill badge-success"><i class="fa-solid fa-book"></i></button>
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