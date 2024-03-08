@extends('layout.main')

@section('content')

<title>{{ $course_check->title }}</title>

<!-- Hero Section -->
<div class="hero-section">
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-4">
        </div>
        <div class="col-sm-12 col-md-5 col-lg-8">
            <div class="container text-white">
                <h2 class="text-white" style="text-align: left;">{{ $course_check->title }}</h2>
                <p class="lead" style="text-align: left;">{{ $course_check->summary }}</p>
                <div class="ratings" style="text-align: left;">
                    @if ($course_count)
                    @php
                    $fullStars = floor($rounded_rating);
                    $halfStar = round($rounded_rating - $fullStars, 1) >= 0.5 ? 1 : 0;
                    $blankStars = 5 - $fullStars - $halfStar;

                    $stars = '';

                    for ($i = 0; $i < $fullStars; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } if ($halfStar) { $stars .='<i class="fa-solid fa-star-half-stroke" style="color: #ffa500;"></i>' ; } for ($i=0; $i < $blankStars; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <p><strong>{{ number_format($rounded_rating, 1) }}</strong> {!! $stars !!} ({{ $course_count }})</p>
                        @else
                        <p>No Reviews Yet</p>
                        @endif
                </div>
                <p class="lead" style="text-align: left;">Created By: {{ $course_check->instructor->name }}
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
                    @if ($course_check->image)
                    <img src="{{ asset('storage/' . $course_check->image) }}" alt="" class="course-img">
                    @else
                    <!-- Placeholder image or any alternative content when $course->image is null -->
                    <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" class="course-img">
                    @endif
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
                        <h5 class="card-price">{{ $course_check->amount == 0 ? 'FREE' : '₱ ' . number_format($course_check->amount, 2) }}</h5>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course_check->course_id }}">
                            @if(Auth::guard('student')->check())
                            @if($course_check->amount == 0 )
                            <a href="{{ route('free.success', ['course_id' => $course_check->course_id]) }}" class="btn btn-primary btn-lg btn-block square">Add to Account</a>
                            @else
                            <button type="submit" class="btn btn-primary btn-lg btn-block square">Add to Cart</button>
                            @endif
                            @elseif(Auth::guard('instructor')->check())
                            @if($course_check->amount == 0 )
                            <a href="#" class="btn btn-lg btn-block square disabled" style="pointer-events: none; background-color: #cccccc; color: #666666;">Add to Account</a>
                            @else
                            <a href="#" class="btn btn-lg btn-block square disabled" style="pointer-events: none; background-color: #cccccc; color: #666666;">Add to Cart</a>
                            @endif
                            @else
                            @if($course_check->amount == 0 )
                            <a href="{{ route('student.login') }}" class="btn btn-primary btn-lg btn-block square">Add to Account</a>
                            @else
                            <a href="{{ route('student.login') }}" class="btn btn-primary btn-lg btn-block square">Add to Cart</a>
                            @endif
                            @endif
                        </form>
                        <p class="display-1" style="font-size: 20px; margin-top: 5%;">Requirements</p>
                        {!! $course_check->requirements !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Panel -->
        <div class="col-sm-12 col-md-7 col-lg-8 ps-4">

            <div class="container">
                <h2 class="display-2" style="font-size: 30px; margin-top: -4%;">What You'll Learn</h2>
                {!! $course_check->wyl !!}
            </div>

            <!-- Accordion Start -->
            <div class="container" style="margin: 50px 0;">
                <h2 class="display-2" style="font-size: 30px; margin-top: -4%;">Course Content</h2>

                <div class="accordion-container">
                    @foreach($course_check->Lessons as $lesson)
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


            <div class="container">
                <h2 class="display-2" style="font-size: 30px; margin-top: 5%;">Description</h2>
                {!! $course_check->description !!}
            </div>
            <div class="container">
                <div class="row" style="margin-top: 5%;">
                    <h2 class="display-2" style="font-size: 30px;">Instructor</h2>
                    <h5 class="card-title">{{$course_check->instructor->name}}</h5>
                    <p class="card-text"></p>

                    <div class="col-sm-12 col-md-2 col-lg-3">
                        <img class="profile-picture-2" src="{{ asset('storage/' . $course_check->instructor_info->profile_picture) }}" alt="...">
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
                        {!! $course_check->instructor_info->bio !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- End of Right Panel -->
    </div>
</div>

@if ($course_list->count() === 0)
<div class="container border rounded" style="padding:50px; margin-top: 80px;margin-bottom: 80px;">
    <h2 class="text-xs-center display-4" style="padding-top: 10px; padding-bottom: 80px;">No More Courses By {{$course_check->instructor->name}}</h2>
</div>
@else
<div class="container border rounded" style="padding:50px; margin-top: 80px;margin-bottom: 80px;">
    <h2 class="text-xs-center display-4" style="padding-top: 10px; padding-bottom: 80px;">Other Courses By {{$course_check->instructor->name}}</h2>
    @foreach($coursesWithReviewsData as $course)
    <div class="container">
        <div class="card mb-10">
            <div class="row g-0">
                <div class="col-md-4 col-sm-12 ">
                    <a href="{{route('course_details', $course->id)}}">
                        @if ($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" class="rounded-start img-fluid img-opacity" style=" height: 100%; width:auto; object-fit:cover;">
                        @else
                        <!-- Placeholder image or any alternative content when $course->image is null -->
                        <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" class="rounded-start img-fluid img-opacity" style=" height: 100%; width:auto; object-fit:cover;">
                        @endif
                    </a>
                </div>
                <div class="col-md-7 col-sm-12 d-flex justify-content-center align-items-center">
                    <div class="card-body">
                        <h4 class="h4-opacity clamp-two-lines" style="margin: 10px 0;"><a href="{{route('course_details', $course->id)}}" class="link-opacity">{{$course->title}}</a>
                        </h4>
                        <p class="card-text"><small class="text-body-secondary">{{ $course->instructor->name}}</small>
                        <p>
                            @php
                            $averageScore = $coursesWithReviewsData->where('course_id', $course->course_id)->first();
                            @endphp
                        <div class="ratings">
                            @if ($averageScore->average_score)
                            @php
                            $fullStars = floor($averageScore->average_score);
                            $halfStar = round($averageScore->average_score - $fullStars, 1) >= 0.5 ? 1 : 0;
                            $blankStars = 5 - $fullStars - $halfStar;
                            $stars = '';
                            for ($i = 0; $i < $fullStars; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } if ($halfStar) { $stars .='<i class="fa-solid fa-star-half-stroke" style="color: #ffa500;"></i>' ; } for ($i=0; $i < $blankStars; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <p><strong>{{number_format($averageScore->average_score, 1) }}</strong> {!! $stars !!} ({{ $averageScore->reviewer_count }})</p>
                                @else
                                <p>No Reviews Yet</p>
                                @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif