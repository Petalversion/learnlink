<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<style>
    * {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
    }

    .exo-h3 {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
        font-size: 40px;
    }

    .exo-h2 {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
        font-size: 50px;
    }

    .exo-h1 {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
        font-size: 70px;
    }

    .exo-p {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
        font-size: 15px;
    }

    .exo-price {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
        font-size: 20px;
    }

    .exo-title {
        font-family: "Exo 2", sans-serif;
        font-optical-sizing: auto;
        font-size: 25px;
    }
</style>
@extends('layout.main')

@section('content')

<title>{{ $course_check->title }}</title>

<!-- Hero Section -->
<div class="hero-section" style="height: 700px;">
    <div class="row  ">
        <div class="col-sm-12 col-md-5 col-lg-4">
        </div>
        <div class="col-sm-12 col-md-5 col-lg-8 " style="margin-top: 100px;">
            <div class="container text-white">
                <h2 class="text-white exo-h2 " style="text-align: left;">{{ $course_check->title }}</h2>
                <p class="lead exo-p" style="text-align: left;">{{ $course_check->summary }}</p>
                <div class="ratings" style="text-align: left;">
                    @if ($course_count)
                    @php
                    $fullStars = floor($rounded_rating);
                    $halfStar = round($rounded_rating - $fullStars, 1) >= 0.5 ? 1 : 0;
                    $blankStars = 5 - $fullStars - $halfStar;

                    $stars = '';

                    for ($i = 0; $i < $fullStars; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } if ($halfStar) { $stars .='<i class="fa-solid fa-star-half-stroke" style="color: #ffa500;"></i>' ; } for ($i=0; $i < $blankStars; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <p class="lead exo-p"><strong>{{ number_format($rounded_rating, 1) }}</strong> {!! $stars !!} ({{ $course_count }})</p>
                        @else
                        <p class="lead exo-p">No Reviews Yet</p>
                        @endif
                </div>
                <p class="nk-post-title exo-p" style="text-align: left;">Created By: <a href="{{route('instructor.index',['id'=>$instr->id])}}">{{ $course_check->instructor->name }}</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container">
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
                        <h5 class="exo-h3 ">{{ $course_check->amount == 0 ? 'FREE' : '₱ ' . number_format($course_check->amount, 2) }}</h5>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course_check->course_id }}">
                            @if(Auth::guard('student')->check())
                            @if($course_check->amount == 0 )
                            <a href="{{ route('free.success', ['course_id' => $course_check->course_id]) }}" class="btn btn-primary btn-lg btn-block square exo-p">Add to Account</a>
                            @else
                            <button type="submit" class="btn btn-primary btn-lg btn-block square exo-p">Add to Cart</button>
                            @endif
                            @elseif(Auth::guard('instructor')->check())
                            @if($course_check->amount == 0 )
                            <a href="#" class="btn btn-lg btn-block square disabled exo-p" style="pointer-events: none; background-color: #cccccc; color: #666666;">Add to Account</a>
                            @else
                            <a href="#" class="btn btn-lg btn-block square disabled exo-p" style="pointer-events: none; background-color: #cccccc; color: #666666;">Add to Cart</a>
                            @endif
                            @else
                            @if($course_check->amount == 0 )
                            <a href="{{ route('student.login') }}" class="btn btn-primary btn-lg btn-block square exo-p">Add to Account</a>
                            @else
                            <a href="{{ route('student.login') }}" class="btn btn-primary btn-lg btn-block square exo-p">Add to Cart</a>
                            @endif
                            @endif
                        </form>
                        <p class=" exo-p mb-0" style="font-size: 20px; margin-top: 10px;"><strong>Requirements</strong></p>
                        <div style="margin-top:0px;">{!! $course_check->requirements !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Panel -->
        <div class="col-sm-12 col-md-7 col-lg-8 ps-4">

            <div class="container">
                <h2 class="exo-h2" style="font-size: 30px;margin-top:50px;">What You'll Learn</h2>
                {!! $course_check->wyl !!}
            </div>

            <!-- Accordion Start -->
            <div class="container" style="margin: 50px 0;">
                <h2 class="exo-h2" style="font-size: 30px; margin-top: -4%;">Course Content</h2>

                <div class="accordion-container">
                    @foreach($course_check->Lessons as $lesson)
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <h3 class="ps-3 pe-3 m-0 exo-p">{{ $loop->iteration }}. {{ $lesson->title }}</h3>
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
                <h2 class="exo-h2" style="font-size: 30px; margin-top: 5%;">Description</h2>
                {!! $course_check->description !!}
            </div>
            <div class="container" id="instwaktor">
                <div class="row" style="margin-top: 5%;">
                    <div class="col-sm-12 col-md-2 col-lg-3">
                        <img class="profile-picture-2" src="{{ asset('storage/' . $course_check->instructor_info->profile_picture) }}" alt="...">
                    </div>
                    <h2 class="exo-h2" style="font-size: 30px;margin-top: 2%;">Instructor</h2>
                    <h5 class="card-title exo-h3" style="font-size: 20px;">{{$course_check->instructor->name}}</h5>
                    <p class="card-text"></p>
                    <div class="col-sm-12 col-md-5 col-lg-9 d-flex align-items-center">
                        <ul class="pl-0 ml-0 list-unstyled mb-0">
                            <li><i class="fa-solid fa-star fa-sm"></i> {{$totalAverageReviews}} Instructor Rating</li>
                            <li><i class="fa-solid fa-award fa-lg"></i> {{$totalReviews}} {{ $totalStudents > 1 ? 'Reviews' : 'Review' }}</li>
                            <li><i class="fa-solid fa-user-graduate"></i> {{$totalStudents}} {{ $totalStudents > 1 ? 'Students' : 'Student' }}</li>
                            <li><i class="fa-solid fa-book"></i> {{$totalCourses}} {{ $totalCourses > 1 ? 'Courses' : 'Course' }}</li>
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
    <h2 class="text-xs-center exo-h3" style="padding-top: 10px; padding-bottom: 80px;">No More Courses By {{$course_check->instructor->name}}</h2>
</div>
@else
<div class="container border rounded" style="padding:50px; margin-top: 80px;margin-bottom: 80px;">
    <h2 class="text-xs-center exo-h3" style="padding-top: 10px; padding-bottom: 80px;">Other Courses By {{$course_check->instructor->name}}</h2>
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
<script>
    function scrollAboveDiv(id, event) {
        event.preventDefault();
        var element = document.getElementById(id);
        if (element) {
            var offset = -50; // Adjust this value as needed
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'end',
                inline: 'nearest'
            });
            window.scrollBy(0, offset);
        }
    }
</script>
@endsection