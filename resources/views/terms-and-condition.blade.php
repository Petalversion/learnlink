<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Terms and Conditions</title>

    <meta name="description" content="Snow - Clean & Minimal Portfolio HTML template.">
    <meta name="keywords" content="portfolio, clean, minimal, blog, template, portfolio website">
    <meta name="author" content="nK">

    <link rel="icon" type="image/png" href="assets/images/favicon.png">


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

        .nk-main>.container>.row>.col>h2,
        .nk-main>.container>.row>.col>h3,
        .nk-main>.container>.row>.col>h4 {
            font-family: "Exo 2", sans-serif;
            font-optical-sizing: auto;
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i%7cWork+Sans:400,500,700" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="/css/landing_combined.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- END: Styles -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
@extends('layout.main')

@section('content')
<div class="nk-main">
    <!-- START: Header Title -->
    <div class="nk-header-title " style="height:350px !Important;">
        <div class="bg-image">
            <div style="background-image: url('/img/terms.jpg'); background-position: center;"></div>
            <div class="bg-image-overlay" style="background-color: rgba(6, 6, 8, 0.450);"></div>
        </div>
        <div class="nk-header-table">
            <div class="nk-header-table-cell">
                <div class="container">
                    <h2 class="nk-subtitle text-white" style="font-size: 50px; margin-bottom: 160px;text-align:left;">
                        Terms and Conditions</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Header Title -->
    <div class="container mt-50 mb-50" style="border: 0px solid #d3d3d3 !important; padding: 40px; border-radius: 5px;">
        <div class="row">
            <div class="col">
                {!!$toc->content!!}
            </div>

        </div>
    </div>

    <script src="/js/combined.js"></script>
    @endsection