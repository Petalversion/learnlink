<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/landing_combined.css">
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: "Exo 2", sans-serif;
      font-optical-sizing: auto;
    }

    body {
      margin: 0;
      height: 0;
      background-color: #ffffff;
    }

    .icon-bar {
      position: fixed;
      top: 50%;
      transform: translateY(-50%);
    }

    .icon-bar a {
      display: block;
      text-align: center;
      padding: 16px;
      transition: all 0.3s ease;
      color: white;
      font-size: 20px;
    }

    .icon-bar a:hover {
      background-color: #000;
    }

    .facebook {
      background: #3B5998;
    }

    .twitter {
      background: #55ACEE;
    }

    .google {
      background: #dd4b39;
    }

    .linkedin {
      background: #007bb5;
    }

    .youtube {
      background: #bb0000;
    }

    .content {
      /* margin-left: 75px; */
      font-size: 30px;
    }
  </style>
</head>
@extends('layout.main')

@section('content')
<div class="nk-main">
  <!-- START: Header Title -->
  <div class="nk-header-title" style="height:350px !Important;">
    <div class="bg-image">
      <div style="background-image: url('/img/proo.jpg'); background-position: center;"></div>
      <div class="bg-image-overlay" style="background-color: rgba(6, 6, 8, 0.450);"></div>
    </div>
    <div class="nk-header-table">
      <div class="nk-header-table-cell">
        <div class="container">
          <h2 class="nk-subtitle text-white" style="font-size: 50px; margin-bottom: 160px;text-align:left;">Contact Us</h2>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Header Title -->

  <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height:700px;">
    <div class="row mb-30">
      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
      <div class="col-md-12 col-sm-12 col-lg-6 order-2 order-md-1 order-lg-1 d-flex flex-column justify-content-center align-items-center">
        <div class="content">
          <p style="font-size: 20px; margin-left: 30px;margin-bottom: 30px; margin-top: 20px;">Have questions? The quickest way
            to get in touch with us is using the contact information below.</p>
          <form action="{{ route('contact.send') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-12 px-5 pb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name">
              </div>
              <div class="col-12 px-5 pb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
              </div>
              <div class="col-12 px-5 pb-3">
                <textarea class="form-control" name="message" id="" cols="30" rows="5" placeholder="Message"></textarea>
              </div>
              <div class="col-12 px-5 pb-3">
                <input type="submit" value="Send Message" class="btn btn-success">
              </div>
            </div>
          </form>

        </div>


      </div>
      <div class="col-md-12 col-sm-12 col-lg-6 order-1 order-md-2 order-lg-2 text-center">
        <img src="/img/gg.png" class="img-fluid" alt="Your Image">
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection