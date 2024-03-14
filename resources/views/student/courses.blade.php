@extends('layout.main-side')

@section('content')
<title>{{$name}} - My Courses</title>

<div class="sidetoppadding">
    <h1 class="h3 mb-3 text-gray-900">Your Courses</h1>
    @if(isset($courseinfo) && !empty($courseinfo))
    <div class="row mb-4">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @foreach($courseinfo as $course)
        <div class="col-md-6 col-lg-3 col-sm-12">
            <div class="card mb-4">
                @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="...">
                @else
                <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" class="card-img-top">
                @endif

                <div class="card-body">
                    <h5 class="card-title clamp-two-lines">{{$course->title}}</h5>
                    <!-- <p class="card-text">{{$course->summary}}</p> -->
                    <!-- <div class="ratings text-center mb-2">
                        Add your rating HTML here
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star unchecked"></span>
                      </div> -->
                    <div class="text-center">
                        @if(isset($course->first_lesson))
                        <a href="{{ route('student.learn', ['course_id' => $course->course_id, 'lesson_id' => $course->first_lesson->lesson_id]) }}" class="btn btn-primary btn-sm">View Course</a>
                        @else
                        <!-- Handle the case where there is no lesson associated with the course -->
                        <a href="{{ route('student.learn', ['course_id' => $course->course_id, 'lesson_id' => 0]) }}" class="btn btn-primary btn-sm">View Course</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="row">
        <div class="col-xl-12">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-center align-items-center">You do not have any Courses</h6>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- </div> -->
    <!-- Card area end -->
</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
@endsection