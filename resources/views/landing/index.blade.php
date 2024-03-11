<!DOCTYPE html>


<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>LearnLink</title>

  <meta name="description" content="Snow - Clean & Minimal Portfolio HTML template.">
  <meta name="keywords" content="portfolio, clean, minimal, blog, template, portfolio website">
  <meta name="author" content="nK">

  <link rel="icon" type="image/png" href="/img/favicon.png">


  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- START: Styles -->
  <style>
    .clamp-two-lines {
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;

    }

    .course-img {
      width: 100%;
      /* Ensure the image takes up the full width of the container */
      height: 75% !important;
      /* Ensure the image takes up the full height of the container */
      object-fit: cover;
      /* Crop the image to cover the entire container, maintaining aspect ratio */
    }

    .bg-img {
      background-image: url('/img/bg-pattern.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 500px;
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
    }

    .bg-img img {
      max-width: 100%;
      margin: auto;
    }

    .custom-btn {
      color: #fff;
      background-color: #31dcfe;
    }

    .custom-btn:hover {
      color: #31dcfe;
      background-color: #fff;
    }

    @media (max-width: 767px) {
      .bg-img {
        height: auto;
        min-height: 700px;
      }

      .row {
        flex-direction: column;
      }

      .col-md-6 {
        order: 2;
      }

      .col-md-6,
      .col-sm-12 {
        text-align: center;
      }

      .bg-img img {
        width: 60%;
      }

      .text-center {
        width: 100%;
        margin-top: 15px;
        margin: auto;
      }
    }

    .vertical-center {
      align-items: center;
    }
  </style>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i%7cWork+Sans:400,500,700" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="/css/landing_combined.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- END: Styles -->


</head>
@extends('layout.main')

@section('content')
<div class="nk-main">

  <!-- START: Header Title -->
  <div class="nk-header-title nk-header-title-full">
    <div class="bg-image">
      <div style="background-image: url('/img/online.jpg');"></div>
      <div class="bg-image-overlay" style="background-color: rgba(12, 12, 12, 0.6);"></div>
    </div>
    <div class="nk-header-table">
      <div class="nk-header-table-cell">
        <div class="container">
          <h2 class="nk-subtitle text-white">LearnLink</h2>
          <h1 class="nk-title display-3 text-white">We are about to change the way
            <br>
            <em class="fw-400">you publish on the web</em>
          </h1>


          <div class="nk-gap"></div>
          <div class="nk-header-text text-white">
            <div class="nk-gap-4"></div>
          </div>


        </div>
      </div>
    </div>
  </div>

  <div id="nk-header-title-scroll-down"></div>

  <!-- END: Header Title -->

  <!-- START: Blog -->


  <h2 class="text-xs-center display-4" style="padding-top: 50px; padding-bottom: 30px;">Fresh New Courses</h2>

  <div class="nk-carousel-2 nk-carousel-x2 nk-carousel-no-margin nk-carousel-all-visible nk-blog-isotope" data-dots="true">
    <div class="nk-carousel-inner">
      @foreach($coursesWithReviewsData as $course)
      <div>
        <div>

          <div class="pl-15 pr-15">
            <div class="nk-blog-post">

              <div class="nk-post-thumb">
                <a href="{{route('course_details', $course->id)}}">
                  @if ($course->image)
                  <img src="{{ asset('storage/' . $course->image) }}" alt="" class="course-img">
                  @else
                  <!-- Placeholder image or any alternative content when $course->image is null -->
                  <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" class="course-img">
                  @endif
                </a>
              </div>
              <h2 class="nk-post-title h4 clamp-two-lines"><a href="{{route('course_details', $course->id)}}">{{ $course->title }}</a></h2>

              <div class="nk-post-date">
                {{ $course->instructor->name }}
              </div>

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

              <div class="nk-post-text">
                <p>
                  {{ $course->amount == 0 ? 'FREE' : '₱ ' . number_format($course->amount, 2) }}
                </p>
                <!-- <button class="btn btn-primary" onclick="location.href='#'">Add to Cart</button> -->
              </div>
            </div>

          </div>
          <div class="nk-gap-1"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- START: Partners -->
  <div class="bg-white" style="margin-top:50px;">
    <div class="container-fluid">
      <div class="nk-carousel-2">
        <div class="nk-carousel-inner">
          <div>
            <div>
              <div class="nk-box-1 text-center">
                <img src="/img/Sony-logo.png" alt="" class="nk-img-fit" style="max-height: 150px;">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1 text-center">
                <img src="/img/Google-Black-and-White.png" alt="" class="nk-img-fit" style="max-height: 150px;">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/new-rakk-logo_yeua.png" alt="" class="nk-img-fit" style="max-height: 150px;">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/MSI-Logo-500x281.png" alt="" class="nk-img-fit" style="max-height: 150px;">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class=" nk-box-1">
                <img src="/img/Asus-Logo.png" alt="" class="nk-img-fit" style="max-height: 150px;">
              </div>
            </div>
          </div>
          <div>
            <div class=" nk-box-1">
              <img src="/img/nin.png" alt="" class="nk-img-fit" style="max-height: 150px;">
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
  <!-- END: Features -->
  <h2 class="text-xs-center display-4" style="padding-top: 50px; padding-bottom: 30px;">Popular Courses</h2>

  <div class="nk-carousel-2 nk-carousel-x2 nk-carousel-no-margin nk-carousel-all-visible nk-blog-isotope" data-dots="true">
    <div class="nk-carousel-inner">
      @foreach($coursesWithReviewsDatarandom as $course)
      <div>
        <div>

          <div class="pl-15 pr-15">
            <div class="nk-blog-post">

              <div class="nk-post-thumb">
                <a href="{{route('course_details', $course->id)}}">
                  @if ($course->image)
                  <img src="{{ asset('storage/' . $course->image) }}" alt="" class="course-img">
                  @else
                  <!-- Placeholder image or any alternative content when $course->image is null -->
                  <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" class="course-img">
                  @endif
                </a>

              </div>
              <h2 class="nk-post-title h4 clamp-two-lines"><a href="{{route('course_details', $course->id)}}">{{ $course->title }}</a></h2>

              <div class="nk-post-date">
                {{ $course->instructor->name }}
              </div>
              @php
              $averageScore = $coursesWithReviewsDatarandom->where('course_id', $course->course_id)->first();
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

              <div class="nk-post-text">
                <p>
                  {{ $course->amount == 0 ? 'FREE' : '₱ ' . number_format($course->amount, 2) }}
                </p>
                <!-- <button class="btn btn-primary" onclick="location.href='#'">Add to Cart</button> -->
              </div>
            </div>

          </div>
          <div class="nk-gap-1"></div>
        </div>
      </div>
      @endforeach

    </div>
  </div>


  <!-- Become an Instructor -->
  <div class="bg-img" style="margin-top:50px;">

    <div class="col-lg-6">
      <div class="text-center">
        <h1 class="text-white" style="color:#31dcfe; margin-bottom: 30px;">Come Teach with Us</h1>
        <p class="text-white">
          Teaching is not just a profession; it's a calling. It's about inspiring minds, empowering individuals, and shaping the future. Whether you're an expert in technology, art, business, or any other domain, there are countless learners eager to benefit from your wisdom..</p>
        <a href="{{ route('become.instructor') }}" class="btn custom-btn">Learn More</a>
      </div>
    </div>

  </div>
</div>
@endsection
@yield('includes.footer')