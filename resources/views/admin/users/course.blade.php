@extends('layout.main-side')

@section('content')
<title>Admin - All Courses</title>

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
                            <td style="vertical-align: middle;">{{$course->title}}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                <span class="badge rounded-pill {{$course->difficulty == 'beginner' ? 'badge-beginner' : ($course->difficulty == 'intermediate' ? 'badge-intermediate' : 'badge-expert')}}">
                                    {{$course->difficulty}}
                                </span>
                            </td>
                            <td style="vertical-align: middle;">{{ $course->paid == 1 ? 'Paid' : 'Free' }}</td>
                            <td class="text-end" style="vertical-align: middle;">{{ $course->paid == 1 ? '₱' . ' ' .
                                                        number_format($course->amount, 2) : 'Free' }}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                <button type="button" onclick="window.location='{{ route('admin.lesson', ['course_id' => $course->id]) }}'" class=" btn btn-pill btn-success"><i class="fa-solid fa-book" style="color: #ffffff;"></i> Lessons</button>
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