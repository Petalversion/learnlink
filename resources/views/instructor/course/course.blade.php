@extends('layout.main-side')

@section('content')
<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">
    <div class="row">
        <div class="col-md-6">
            <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-book-open"></i> Course</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('instructor.course.course-create') }}" class="btn btn-primary btn-icon-split p-0"><span class="icon text-white-50 "><i class="fas fa-plus"></i></span><span class="text">Course</span></a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <table class="table table-striped" id="myTable12345">
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
                        @foreach($courses as $course)
                        <tr>
                            <td>{{$course->title}}</td>
                            <td>
                                {{$course->difficulty}}
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