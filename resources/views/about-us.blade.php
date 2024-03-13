<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>About Us</title>

  <meta name="description" content="Snow - Clean & Minimal Portfolio HTML template.">
  <meta name="keywords" content="portfolio, clean, minimal, blog, template, portfolio website">
  <meta name="author" content="nK">

  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- START: Styles -->
  <style>
    * {
      font-family: "Exo 2", sans-serif;
      font-optical-sizing: auto;
    }

    .searchbutton {
      margin: 0 10px !important;
    }

    .nk-carousel-2.nk-carousel-x2 .flickity-slider>div {
      width: 20% !important;
    }

    .bg-img {
      background-image: url('assets/images/bg-pattern.jpg');
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
  <div class="nk-header-title " style="height:350px !Important;">
    <div class="bg-image">
      <div style="background-image: url('/img/boy.jpg'); background-position: center;"></div>
      <div class="bg-image-overlay" style="background-color: rgba(6, 6, 8, 0.450);"></div>
    </div>
    <div class="nk-header-table">
      <div class="nk-header-table-cell">
        <div class="container">
          <h2 class="nk-subtitle text-white" style="font-size: 50px; margin-bottom: 160px;text-align:left;">About Us</h2>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Header Title -->
  <div class="container mt-50 mb-50" style="border: 0px solid #d3d3d3 !important; padding: 40px; border-radius: 5px;">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-8 pr-50">
        <p>Welcome to LearnLink, your gateway to a world of knowledge and possibilities. LearnLink has been dedicated to empowering individuals through accessible and engaging learning experiences. At LearnLink, we specialize in creating dynamic and user-friendly learning platforms to make education accessible to everyone. Our team is passionate about facilitating effective learning journeys and fostering a love for continuous education.</p>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4 mt-50">
        <img class="img-fluid" src="/img/blcck.png" alt="">
      </div>
    </div>
  </div>

  <div class="container mb-50 p-0">
    <div class="col-sm-12 col-md-6 col-lg-6 p-0">
      <div class="container p-0 p-50" style="background-color: #efefef;">
        <h1 class="nk-subtitle text-black" style="font-size: 30px;">Students</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius voluptate sequi perferendis, mollitia ab maiores unde iusto illo voluptates et quaerat aspernatur recusandae in similique culpa dolor, quisquam perspiciatis ratione omnis tempora delectus.</p>
        <a href="{{route('student.register')}}" class="btn btn-info">Learn More</a>
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 p-0">
      <div class="container p-0 p-50" style="background-color: #e5e5e5;">
        <h1 class="nk-subtitle text-black" style="font-size: 30px;">Instructor</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius voluptate sequi perferendis, mollitia ab maiores unde iusto illo voluptates et quaerat aspernatur recusandae in similique culpa dolor, quisquam perspiciatis ratione omnis tempora delectus.</p>
        <a href="{{route('become.instructor')}}" class="btn btn-info">Learn More</a>
      </div>
    </div>
  </div>
</div>
<script src="/js/combined.js"></script>
@endsection