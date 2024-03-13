<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{$instr->name}}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/landing_combined.css">
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<style>
  body {
    background-color: #fff;
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

  .container>.row>.bio>p {
    font-family: "Exo 2", sans-serif;
    font-optical-sizing: auto;
    font-size: 20px;
  }
</style>

@extends('layout.main')

@section('content')
<div class="nk-main">
  <!-- START: Header Title -->
  <div class="nk-header-title" style="height:520px !Important;">
    <div class="bg-image">
      <div style="background-image: url('/img/blue.jpg'); background-position: center;"></div>
      <div class="bg-image-overlay" style="background-color: rgba(6, 6, 8, 0.450);"></div>
    </div>
    <div class="nk-header-table">
      <div class="nk-header-table-cell">
        <div class="container">
          <div class="col-lg-12 d-flex align-items-center pb-3">
            <img class="profile-picture-2 mx-auto d-block" style="min-height:175px;min-width:175px;" src="{{ asset('storage/' . $instr_info->profile_picture) }}" alt="...">
          </div>
          <div class="container col-lg-12 d-flex align-items-center pb-3">
            <h2 class="card-title mx-auto d-block text-white exo-h2">{{$instr->name}}</h2>
          </div>
          <div class="col-lg-12 d-flex align-items-center p-5">
            <span class="card-title mx-auto d-block text-white exo-p"><i class="fa-solid fa-star fa-sm"></i> {{$totalAverageReviews}} Instructor Rating | <i class="fa-solid fa-award fa-lg"></i> {{$totalReviews}} {{ $totalStudents > 1 ? 'Reviews' : 'Review' }} | <i class="fa-solid fa-user-graduate"></i> {{$totalStudents}} {{ $totalStudents > 1 ? 'Students' : 'Student' }} | <i class="fa-solid fa-book"></i> {{$totalCourses}} {{ $totalCourses > 1 ? 'Courses' : 'Course' }} </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row" style="margin-top: 5%;">
      <div class="col-lg-12 p-5 bio">
        {!! $instr_info->bio !!}
      </div>
    </div>
  </div>


  <div class="container" style="min-height:600px;margin-top: 20px;">

    @if(!$coursesWithReviewsData->isEmpty())
    <h1 class="text-center pb-5 exo-h2">Courses</h1>
    <hr style="border-width:1px;border-color: gray;">
    <div class="row mb-5">
      <!-- Sidebar: Filter Column -->
      <div class="items col-lg-12">

        @foreach($coursesWithReviewsData as $datas)
        <div class="row {{$datas->difficulty}}" style="margin-top: 10px; margin-bottom: 10px;">
          <!-- Course Product Card -->
          <div class="col-lg-2 col-sm-10">
            <div class="card-body">
              <a href="{{route('course_details', $datas->id)}}">
                @if ($datas->image)
                <img src="{{ asset('storage/' . $datas->image) }}" class="card-img-top" alt="...">
                @else
                <!-- Placeholder image or any alternative content when $course->image is null -->
                <img src="{{ asset('img/course_placeholder.png') }}" class="card-img-top">
                @endif
              </a>
            </div>
          </div>
          <div class="col-lg-8">

            <h5 class="nk-post-title exo-title"><a href="{{route('course_details', $datas->id)}}">{{$datas->title}}</a></h5>
            <p class="card-text mb-5 exo-p">{{$datas->summary}}</p>
            @php
            $name = \App\Models\Instructor::where('instructor_id', $datas->instructor_id)->first();
            @endphp

            <p class="card-text mt-0 exo-p">Instructor: <strong class="nk-post-title"><a href="{{route('instructor.index',['id'=>$name->id])}}">{{$name->name}}</a></strong></p>
            <div class="ratings" style="margin-top: -15px;">
              @if ($datas->average_score)
              @php
              $fullStars = floor($datas->average_score);
              $halfStar = round($datas->average_score - $fullStars, 1) >= 0.5 ? 1 : 0;
              $blankStars = 5 - $fullStars - $halfStar;

              $stars = '';

              for ($i = 0; $i < $fullStars; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } if ($halfStar) { $stars .='<i class="fa-solid fa-star-half-stroke" style="color: #ffa500;"></i>' ; } for ($i=0; $i < $blankStars; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <p class="exo-p"><strong>{{number_format($datas->average_score, 1) }}</strong> {!! $stars !!} ({{ $datas->reviewer_count }})</p>
                @else
                <p class="exo-p">No Reviews Yet</p>
                @endif
            </div>
            <p class="card-text exo-p" style="margin-top: -15px;margin-bottom: 15px;">
              <span class="badge rounded-pill {{$datas->difficulty == 'beginner' ? 'badge-beginner' : ($datas->difficulty == 'intermediate' ? 'badge-intermediate' : 'badge-expert')}}">
                {{$datas->difficulty ? strtoupper($datas->difficulty) : ''}}
              </span>
              <span class="badge rounded-pill badge-lessons">{{count($datas->lessons)}} {{count($datas->lessons) > 1 ? 'LESSONS' : 'LESSON'}}</span>
            </p>
          </div>
          <div class="col-lg-2 text-end exo-price">
            @if($datas->amount == 0)
            <strong class="exo-price">FREE</strong>
            @else
            <strong class="text-muted">₱ {{number_format($datas->amount, 2)}}</strong>
            @endif
          </div>
          <hr style="border-width:1px;border-color: gray;">
        </div>
        @endforeach
      </div>
    </div>
    @else
    <div class="col-lg-12">
      <h1 class="nk-title exo-h2 text-center pb-5">No Courses Yet</h1>
    </div>
    @endif
  </div>
</div>
<script>
  const searchForm = document.getElementById('searchForm');
  const freeCheckbox = document.getElementById('freeCheckbox');
  const paidCheckbox = document.getElementById('paidCheckbox');
  const beginnerCheckbox = document.getElementById('beginnerCheckbox');
  const intermediateCheckbox = document.getElementById('intermediateCheckbox');
  const expertCheckbox = document.getElementById('expertCheckbox');
  var categoryRadios = document.querySelectorAll('.categoryRadio');

  // Add event listener to the checkbox
  freeCheckbox.addEventListener('change', function() {
    // Automatically submit the form when the checkbox value changes
    searchForm.submit();
  });

  paidCheckbox.addEventListener('change', function() {
    // Automatically submit the form when the checkbox value changes
    searchForm.submit();
  });

  beginnerCheckbox.addEventListener('change', function() {
    // Automatically submit the form when the checkbox value changes
    searchForm.submit();
  });

  intermediateCheckbox.addEventListener('change', function() {
    // Automatically submit the form when the checkbox value changes
    searchForm.submit();
  });

  expertCheckbox.addEventListener('change', function() {
    // Automatically submit the form when the checkbox value changes
    searchForm.submit();
  });

  categoryRadios.forEach(function(radio) {
    // Add change event listener
    radio.addEventListener('change', function() {
      // Automatically submit the form when the radio button value changes
      searchForm.submit();
    });
  });
</script>
@endsection