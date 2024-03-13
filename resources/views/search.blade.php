<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> {{number_format(count($coursesWithReviewsData))}} results for "{{$search}}"</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/landing_combined.css">
</head>

<style>
  body {
    background-color: #fff;
  }
</style>

@extends('layout.main')

@section('content')
<div class="nk-main">
  <!-- START: Header Title -->
  <div class="nk-header-title " style="height:350px !Important;">
    <div class="bg-image">
      <div style="background-image: url('/img/online.jpg'); background-position: center;"></div>
      <div class="bg-image-overlay" style="background-color: rgba(6, 6, 8, 0.450);"></div>
    </div>
    <div class="nk-header-table">
      <div class="nk-header-table-cell">
        <div class="container">
          <h1 class="nk-title display-3 text-white text-start" style="margin-top: -110px;">We are about to change the way
            <br>
            <em class="fw-400 text-start">you publish on the web</em>
          </h1>
        </div>
      </div>
    </div>
  </div>

  <div class="container" style="min-height:600px;margin-top: 20px;">
    <div class="col-lg-12">
      <strong style="font-size:30px;"> {{number_format(count($coursesWithReviewsData))}} results for "{{$search}}"</strong>
    </div>
    @if(!$coursesWithReviewsData->isEmpty())
    <div class="row mb-5">
      <!-- Sidebar: Filter Column -->
      <div class="col-lg-2" style="margin-top: 10px;">
        <form action="{{ route('search') }}" method="get" id="searchForm">
          <hr class="mt-0" style="background-color: gray;width: 100%;margin-bottom: 10px;">
          <h5>Level</h5>
          <div class="form-check">
            @php
            $beginnerCount = 0;
            @endphp

            @foreach($coursesWithReviewsData as $datas)
            @if($datas->difficulty == "beginner")
            @php
            $beginnerCount++;
            @endphp
            @endif
            @endforeach
            <input class="form-check-input" type="checkbox" name="beginner" value="beginner" id="beginnerCheckbox" {{ request()->has('beginner') ? 'checked' : '' }}>
            <label class="form-check-label" for="flexCheckDefault">Beginner ({{$beginnerCount}})</label>
          </div>
          <div class="form-check">
            @php
            $intermediateCount = 0;
            @endphp

            @foreach($coursesWithReviewsData as $datas)
            @if($datas->difficulty == "intermediate")
            @php
            $intermediateCount++;
            @endphp
            @endif
            @endforeach
            <input class="form-check-input" type="checkbox" name="intermediate" value="intermediate" id="intermediateCheckbox" {{ request()->has('intermediate') ? 'checked' : '' }}>
            <label class="form-check-label" for="flexCheckChecked">Intermediate ({{$intermediateCount}})</label>
          </div>
          <div class="form-check">
            @php
            $expertCount = 0;
            @endphp

            @foreach($coursesWithReviewsData as $datas)
            @if($datas->difficulty == "expert")
            @php
            $expertCount++;
            @endphp
            @endif
            @endforeach
            <input class="form-check-input" type="checkbox" name="expert" value="expert" id="expertCheckbox" {{ request()->has('expert') ? 'checked' : '' }}>
            <label class="form-check-label" for="flexCheckChecked2">Expert ({{$expertCount}})</label>
          </div>



          <input class="search" id="searchleft" type="hidden" name="search" value={{$search}}>
          <hr class="mt-0" style="background-color: gray;width: 100%;margin-bottom: 10px;">
          <h5>Price</h5>
          <div class="form-check">
            @php
            $freeCount = 0;
            @endphp

            @foreach($coursesWithReviewsData as $datas)
            @if($datas->free == "1")
            @php
            $freeCount++;
            @endphp
            @endif
            @endforeach
            <input class="form-check-input" type="checkbox" name="free" value="1" id="freeCheckbox" {{ request()->has('free') ? 'checked' : '' }}>
            <label class="form-check-label" for="flexCheckDefault">Free ({{$freeCount}})</label>
          </div>
          <div class="form-check">
            @php
            $paidCount = 0;
            @endphp

            @foreach($coursesWithReviewsData as $datas)
            @if($datas->paid == "1")
            @php
            $paidCount++;
            @endphp
            @endif
            @endforeach
            <input class="form-check-input" type="checkbox" name="paid" value="1" id="paidCheckbox" {{ request()->has('paid') ? 'checked' : '' }}>
            <label class="form-check-label" for="flexCheckChecked">Paid ({{$paidCount}})</label>
          </div>
          <hr class="mt-0" style="background-color: gray;width: 100%;margin-bottom: 10px;">
          <h5>Categories</h5>
          @foreach ($categories as $category)
          @php
          $categoryCount = 0;
          @endphp
          @foreach($coursesWithReviewsData as $datas)
          @if($datas->category == $category->id)
          @php
          $categoryCount++;
          @endphp
          @endif
          @endforeach
          <div class="form-check" id="radioCategory">
            <input type="radio" name="category" value="{{ $category->id }}" class="form-check-input categoryRadio" {{  request()->has('category') && $category->id == $_GET['category'] ? 'checked' : '' }}>
            <label class="form-check-label" for="categoryRadio_{{ $category->id }}">{{ $category->name }} ({{$categoryCount}})</label>
          </div>
          @endforeach
        </form>
        <hr>
      </div>
      <!-- Main Content -->
      <div class="items col-lg-10">

        <p class="text-end">{{count($coursesWithReviewsData)}} Results</p>
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

            <h5 class="nk-post-title h4"><a href="{{route('course_details', $datas->id)}}">{{$datas->title}}</a></h5>
            <p class="card-text mb-5">{{$datas->summary}}</p>
            @php
            $name = \App\Models\Instructor::where('instructor_id', $datas->instructor_id)->first();
            @endphp

            <p class="card-text mt-0">Instructor: <strong class="nk-post-title"><a href="{{route('instructor.index',['id'=>$name->id])}}">{{$name->name}}</a></strong></p>
            <div class="ratings" style="margin-top: -15px;">
              @if ($datas->average_score)
              @php
              $fullStars = floor($datas->average_score);
              $halfStar = round($datas->average_score - $fullStars, 1) >= 0.5 ? 1 : 0;
              $blankStars = 5 - $fullStars - $halfStar;

              $stars = '';

              for ($i = 0; $i < $fullStars; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } if ($halfStar) { $stars .='<i class="fa-solid fa-star-half-stroke" style="color: #ffa500;"></i>' ; } for ($i=0; $i < $blankStars; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <p><strong>{{number_format($datas->average_score, 1) }}</strong> {!! $stars !!} ({{ $datas->reviewer_count }})</p>
                @else
                <p>No Reviews Yet</p>
                @endif
            </div>
            <p class="card-text" style="margin-top: -15px;margin-bottom: 15px;">
              <span class="badge rounded-pill {{$datas->difficulty == 'beginner' ? 'badge-beginner' : ($datas->difficulty == 'intermediate' ? 'badge-intermediate' : 'badge-expert')}}">
                {{$datas->difficulty ? strtoupper($datas->difficulty) : ''}}
              </span>
              <span class="badge rounded-pill badge-lessons">{{count($datas->lessons)}} {{count($datas->lessons) > 1 ? 'Lessons' : 'Lesson'}}</span>
            </p>
          </div>
          <div class="col-lg-2 text-end">
            @if($datas->amount == 0)
            <small class="text-muted">FREE</small>
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
      <strong style="font-size:30px;"> Sorry, we couldn't find any results for "{{$search}}"</strong>
      <p style="margin-top:15px;margin-bottom:10px;"><strong style="font-size:22px;">Try adjusting your search. Here are some ideas:</strong> </p>
      <li>Make sure all words are spelled correctly</li>
      <li>Try different search terms</li>
      <li>Try more general search terms</li>
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