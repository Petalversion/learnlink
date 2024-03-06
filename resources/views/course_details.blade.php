@extends('layout.main')

@section('content')

@forelse($details as $course)
<title>{{ $course->title }}</title>
@empty
<title>Default</title>
@endforelse

@foreach($details as $course)
<!-- Hero Section -->
<div class="hero-section">
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-4">
        </div>
        <div class="col-sm-12 col-md-5 col-lg-8">
            <div class="container text-white">
                <h2 class="text-white" style="text-align: left;">{{ $course->title }}</h2>
                <p class="lead" style="text-align: left;">{{ $course->summary }}</p>
                <div class="ratings" style="text-align: left;">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star unchecked"></span>
                </div>
                <p class="lead" style="text-align: left;">Created By: {{ $course->instructor->name }}
                </p>
            </div>
        </div>
    </div>


</div>

<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="container-fluid">
                <div class="card sticky-card">
                    <img src="{{ asset('storage/' . $course->image) }}">
                    <div class="card-body">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <h5 class="card-price">{{ $course->amount == 0 ? 'FREE' : '₱ ' . number_format($course->amount, 2) }}</h5>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                            @if(Auth::guard('student')->check())
                            @if($course->amount == 0 )
                            <a href="{{ route('free.success', ['course_id' => $course->course_id]) }}" class="btn btn-primary btn-lg btn-block square">Add to Account</a>
                            @else
                            <button type="submit" class="btn btn-primary btn-lg btn-block square">Add to Cart</button>
                            @endif
                            @elseif(Auth::guard('instructor')->check())
                            @if($course->amount == 0 )
                            <a href="#" class="btn btn-lg btn-block square disabled" style="pointer-events: none; background-color: #cccccc; color: #666666;">Add to Account</a>
                            @else
                            <a href="#" class="btn btn-lg btn-block square disabled" style="pointer-events: none; background-color: #cccccc; color: #666666;">Add to Cart</a>
                            @endif
                            @else
                            @if($course->amount == 0 )
                            <a href="{{ route('student.login') }}" class="btn btn-primary btn-lg btn-block square">Add to Account</a>
                            @else
                            <a href="{{ route('student.login') }}" class="btn btn-primary btn-lg btn-block square">Add to Cart</a>
                            @endif
                            @endif
                        </form>
                        <p class="display-1" style="font-size: 20px; margin-top: 5%;">Requirements</p>
                        {!! $course->requirements !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Panel -->
        <div class="col-sm-12 col-md-7 col-lg-8 ps-4">

            <div class="container">
                <h2 class="display-2" style="font-size: 30px; margin-top: -4%;">What You'll Learn</h2>
                {!! $course->wyl !!}
            </div>

            @foreach($details as $course)
            <!-- Accordion Start -->
            <div class="container" style="margin: 50px 0;">
                <h2 class="display-2" style="font-size: 30px; margin-top: -4%;">Course Content</h2>

                <div class="accordion-container">
                    @foreach($course->Lessons as $lesson)
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <h4 class="ps-3 pe-3 m-0">{{ $loop->iteration }}. {{ $lesson->title }}</h4>
                            <!-- <span>&#9654;</span> -->
                        </div>
                        <!-- 
                        <div class="accordion-content">
                            @foreach($lesson->lecture as $lectures)
                            <p>{{ $loop->iteration }}. {{$lectures->title}}</p>
                            @endforeach
                        </div> -->

                    </div>
                    @endforeach
                </div>

            </div>
            <!-- Accordion End -->
            @endforeach

            <div class="container">
                <h2 class="display-2" style="font-size: 30px; margin-top: 5%;">Description</h2>
                {!! $course->description !!}
            </div>
            <div class="container">
                <div class="row" style="margin-top: 5%;">
                    <h2 class="display-2" style="font-size: 30px;">Instructor</h2>
                    @foreach($details as $course)
                    <h5 class="card-title">{{$course->instructor->name}}</h5>
                    @endforeach
                    <p class="card-text"></p>

                    <div class="col-sm-12 col-md-2 col-lg-3">
                        <img class="profile-picture-2" src="{{ asset('storage/' . $course->instructor_info->profile_picture) }}" alt="...">
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-9 d-flex align-items-center">
                        <ul style="margin-bottom: 0;">
                            <li>[[Instructor->Average_Rating]]</li>
                            <li>[[Instructor->Total_Reviews]]</li>
                            <li>[[Instructor->Total_Students]]</li>
                            <li>[[Instructor->Total_Courses]]</li>
                        </ul>
                    </div>
                    <div style="margin-top: 3%;">
                        {!! $course->instructor_info->bio !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- End of Right Panel -->
    </div>
</div>
<div class="container" style="margin-top: 80px">
    <div class="card mb-3">
        <div class="row g-0">

        </div>
    </div>
</div>

@endforeach



<!----card course-->
@if ($course_list->count() === 0 || $course_list->count() === 1)
<div class="container border rounded" style="padding:50px; margin-top: 80px;margin-bottom: 80px;">
    @foreach ($details as $instructor)
    <h2 class="text-xs-center display-4" style="padding-top: 10px; padding-bottom: 80px;">No More Courses By {{$instructor->instructor->name}}</h2>
    @endforeach
</div>
@else
<div class="container border rounded" style="padding:50px; margin-top: 80px;margin-bottom: 80px;">
    @foreach ($details as $instructor)
    <h2 class="text-xs-center display-4" style="padding-top: 10px; padding-bottom: 80px;">Other Courses By {{$instructor->instructor->name}}</h2>
    @endforeach
    @foreach($course_list as $course)
    <div class="container">
        <div class="card mb-10">
            <div class="row g-0">
                <div class="col-md-4 col-sm-12 ">
                    <a href="{{route('course_details', $course->course_id)}}">
                        <img src="{{ asset('storage/' . $course->image) }}" class="rounded-start img-fluid img-opacity" style=" height: 100%; width:auto; object-fit:cover;">
                    </a>
                </div>
                <div class="col-md-7 col-sm-12 d-flex justify-content-center align-items-center">
                    <div class="card-body">
                        <h4 class="h4-opacity clamp-two-lines" style="margin: 10px 0;"><a href="{{route('course_details', $course->course_id)}}" class="link-opacity">{{$course->title}}</a>
                        </h4>
                        <div class="ratings">
                            <!-- Add your rating HTML here -->
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star unchecked"></span>
                        </div>
                        <p class="card-text"><small class="text-body-secondary">{{ $course->instructor->name}}</small>
                        <p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif