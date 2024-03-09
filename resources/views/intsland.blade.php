<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>LearnLink</title>

  <meta name="description" content="Snow - Clean & Minimal Portfolio HTML template.">
  <meta name="keywords" content="portfolio, clean, minimal, blog, template, portfolio website">
  <meta name="author" content="nK">

  <link rel="icon" type="image/png" href="assets/images/favicon.png">


  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel='stylesheet' href='https://www.littlesnippets.net/css/codepen-result.css'>
  <link rel="stylesheet" href="assets/css/style3.css">


  <!-- START: Styles -->
  <style>
    .searchbutton {
      margin: 0 10px !important;
    }

    .nk-carousel-2.nk-carousel-x2 .flickity-slider>div {
      width: 20% !important;
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

    /* Custom Styles for this page */
    .nk-ibox-1 .nk-ibox-cont {
      margin-left: 0 !important;
    }

    .nk-ibox-cont {
      text-align: center !important;
      margin: 15px 0;
    }

    .nk-ibox-cont .nk-ibox-title {
      font-size: 2rem;
      color: #ffffff;
      font-weight: 800 !important;
    }

    .custom-bg {
      background-color: #60c5db;
      padding: 30px 0;
      border-radius: 30px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      /* Box shadow with color and blur */
    }

    .instructor-vector {
      min-width: 400px !important;
    }

    /* Custom Styles for Testimonial Section */
    html {
      scroll-behavior: smooth;
    }

    .testimonial-container {
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      width: 100%;
      background-color: #555555;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      /* Box shadow with color and blur */
    }

    main {
      width: 800px;
    }

    main h1 {
      text-align: center;
      font-size: clamp(2rem, 4vw, 2.6rem);
      color: #fff;
      margin-top: 30px;
      margin-bottom: 30px;
    }

    main h3 {
      text-align: center;
      font-size: 20px;
      color: #ffffff;
      margin-top: 30px;
      margin-bottom: 30px;
    }

    .name {
      margin-bottom: 10px;
    }

    .title {
      font-size: 16px !important;
    }

    .slide-row {
      display: flex;
      width: 3200px;
      transition: 0.5s;
    }

    .slide-col {
      position: relative;
      width: 800px;
      height: 400px;
    }

    .hero {
      position: absolute;
      top: 0;
      right: 0;
      height: 100%;
    }

    .hero img {
      height: 100%;
      border-radius: 10px;
      width: 320px;
      object-fit: cover;
      pointer-events: none;
      user-select: none;
    }

    .content {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 520px;
      height: 270px;
      color: #4d4352;
      background: rgba(255, 255, 255, 0.7);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(4.5px);
      -webkit-backdrop-filter: blur(4.5px);
      border-radius: 10px;
      padding: 45px;
      z-index: 2;
      user-select: none;
    }

    .content p {
      font-size: 1.25rem;
      font-weight: 400;
      line-height: 1.3;
    }

    .content h2 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-top: 35px;
      color: #4d4352;
    }

    .indicator {
      display: flex;
      justify-content: center;
      margin-top: 4rem;
    }

    .indicator .custom-btn {
      display: inline-block;
      height: 15px;
      width: 15px;
      margin: 4px;
      border-radius: 15px;
      background: #fff;
      cursor: pointer;
      transition: all 0.5s ease-in-out;
    }

    .custom-btn.active {
      width: 30px;
    }

    .custom-slider {
      width: 100%;
      overflow: hidden;
    }

    @media (max-width: 850px) {
      main {
        width: 500px;
      }

      .slide-row {
        width: 2000px;
      }

      .slide-col {
        width: 500px;
        height: 250px;
      }

      .hero img {
        width: 200px;
      }

      .content {
        width: 320px;
        height: 200px;
        padding: 20px;
      }

      .content p {
        font-size: 0.9rem;
      }

      .content h2 {
        font-size: 1.2rem;
        margin-top: 20px;
      }
    }

    @media (max-width: 550px) {
      main {
        width: 300px;
      }

      .slide-row {
        width: 1200px;
      }

      .slide-col {
        width: 500px;
        height: 300px;
      }

      .hero {
        top: 60%;
        height: 100px;
        z-index: 5;
      }

      .hero img {
        width: 100px;
      }

      .content {
        width: 300px;
      }
    }
  </style>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i%7cWork+Sans:400,500,700" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="/css/landing_combined.css">
  <link rel="stylesheet" href="/css/landing.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- END: Styles -->


</head>


@extends('layout.main')

@section('content')
<div class="nk-main">

  <!-- START: Header Title -->
  <div class="nk-header-title nk-header-title-full">
    <div class="bg-image">
      <div class="bg-image-overlay" style="background-image: linear-gradient(rgba(0, 0, 0, 0.589), rgba(0, 0, 0, 0.589)), url('/img/woman.jpg');">
      </div>
    </div>
    <div class="nk-header-table">
      <div class="nk-header-table-cell">
        <div class="container">


          <h2 class="nk-subtitle text-white" style="text-align:left;">Come Teach with Us</h2>


          <h1 class="nk-title display-3 text-white" style="text-align:left;">Become an Instructor and change the world
            <br>
            <em class="fw-400"></em>
          </h1>

          <div class="nk-gap"></div>
          <div class="nk-header-text text-white" style="text-align:left;">
            <!-- <div class="nk-gap-4"></div> -->
            <a href="{{route('instructor.register')}}" class="btn btn-info btn-lg">Get Started</a>
          </div>


        </div>
      </div>
    </div>



  </div>

  <div id="nk-header-title-scroll-down"></div>

  <!-- END: Header Title -->

  <!-- START: Blog -->


  <h2 class="text-xs-center display-4" style="padding-top: 50px; padding-bottom: 30px;">Many Reasons To Start
  </h2>



  <!-- Facilities Start -->
  <div class="container-fluid pl-0 pr-0 pt-5 mb-5">
    <!-- <div class="container "> -->
    <div class="row" style="margin-left:2px;">
      <div class="col-lg-4 col-md-6 pb-1">
        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px">
          <img src="/img/teachchhhh.png" alt="" width="250" height="250">
          <div class="pl-4 d-flex flex-column justify-content-center">
            <h4>Teach your way</h4>
            <p class="m-0">
              Kasd labore kasd et dolor est rebum dolor ut, clita dolor vero
              lorem amet elitr vero...
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 pb-1">
        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px">
          <img src="/img/think.png" alt="" width="250" height="250">
          <div class="pl-4 d-flex flex-column justify-content-center">
            <h4>Inspire Learners</h4>
            <p class="m-0">
              Inspire learners by encouraging curiosity, creating a positive environment, and
              celebrating their achievements. Make learning a joyful journey of discovery.
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 pb-1">
        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px">
          <img src="/img/Achievement.png" alt="" width="250" height="250">
          <div class="pl-4 d-flex flex-column justify-content-center">
            <h4>Get Rewarded</h4>
            <p class="m-0">
              Kasd labore kasd et dolor est rebum dolor ut, clita dolor vero
              lorem amet elitr vero...
            </p>
          </div>
        </div>
      </div>
    </div>


    <!-- START: Features -->

    <div class="nk-gap-5 mnt-6"></div>
    <div class="container">
      <div class="row vertical-gap custom-bg">
        <div class="col-md-6 col-lg-3 p-0 mx-auto">
          <div class="nk-ibox-1">
            <!-- <div class="nk-ibox-icon">
                                        <span class="pe-7s-portfolio"></span>
                                    </div> -->
            <div class="nk-ibox-cont">
              <div class="nk-ibox-title">548M</div>
              <div class="nk-ibox-text">Students</div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 p-0 mx-auto">
          <div class="nk-ibox-1">
            <!-- <div class="nk-ibox-icon">
                                        <span class="pe-7s-clock"></span>
                                    </div> -->
            <div class="nk-ibox-cont">
              <div class="nk-ibox-title">450+</div>
              <div class="nk-ibox-text">Hours</div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 p-0 mx-auto">
          <div class="nk-ibox-1">
            <!-- <div class="nk-ibox-icon">
                                        <span class="pe-7s-star"></span>
                                    </div> -->
            <div class="nk-ibox-cont">
              <div class="nk-ibox-title">612+</div>
              <div class="nk-ibox-text">Enrollments</div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 p-0 mx-auto">
          <div class="nk-ibox-1">
            <!-- <div class="nk-ibox-icon">
                                        <span class="pe-7s-like"></span>
                                    </div> -->
            <div class="nk-ibox-cont">
              <div class="nk-ibox-title">735+</div>
              <div class="nk-ibox-text">Instructors</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="nk-gap-5 mnt-6"></div>
  </div>
  <!-- END: Features -->




  <!-- About Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5 p-0">
          <img class="img-fluid rounded mb-5 mb-lg-0 instructor-vector" src="/img/hihih.png" alt="" />
        </div>
        <div class="col-lg-7 pt-50">

          <h1 class="mb-6" style="font-size: 50px; text-align: center;">How to Begin</h1>
          <p style="margin-top: 4%; text-align: center; font-size: 20px;">
            The way that you teach — what you bring to it — is up to you.
          </p>
          <div class="row pt-2 pb-4">

            <div class="col-6 col-md-8">
              <ul class="list-inline m-1">
                <li class="py-2 border-top border-bottom">
                  <i class="fa fa-check text-primary pr-10"></i>Plan Your Curriculum
                </li>
                <li class="py-2 border-bottom">
                  <i class="fa fa-check text-primary pr-10"></i>Make Your Lesson
                </li>
                <li class="py-2 border-bottom">
                  <i class="fa fa-check text-primary pr-10"></i>Launch Your Course
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->




  <!-- START: Partners -->
  <div class="bg-white">
    <div class="container py-4">
      <div class="nk-carousel-2 nk-carousel-x4 nk-carousel-no-margin nk-carousel-all-visible">
        <div class="nk-carousel-inner">
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/cisco.svg" alt="" class="nk-img-fit">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/citi.svg" alt="" class="nk-img-fit">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/samsung.svg" alt="" class="nk-img-fit">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/ericsson.svg" alt="" class="nk-img-fit">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/volkswagen.svg" alt="" class="nk-img-fit">
              </div>
            </div>
          </div>
          <div>
            <div>
              <div class="nk-box-1">
                <img src="/img/procter_gamble.svg" alt="" class="nk-img-fit">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Partners -->



  <!-- Testimonial Start -->
  <div class="testimonial-container">
    <main>
      <h2 class="text-xs-center display-4" style="padding-top: 50px; color: white; font-weight: 600;">Testimony
      </h2>
      <h3>What Instructor Says</h3>

      <div class="custom-slider">
        <div class="slide-row" id="slide-row">
          <div class="slide-col">
            <div class="content">
              <p>"Helping people around the world improve their careers and build great things. Teaching a skills
                necessary to stand out from the crowd.”</p>
              <div style="border-bottom: 3px solid #898989; max-width: 80px;"></div>
              <h2 class="name">Jennifer Swan</h2>
              <p class="title">Developer</p>
            </div>
            <div class="hero">
              <img src="/img/swan.jpg" alt="avatar">
            </div>
          </div>

          <div class="slide-col">
            <div class="content">
              <p>"Helping people around the world improve their careers and build great things. Teaching a skills
                necessary to stand out from the crowd.”</p>
              <div style="border-bottom: 3px solid #898989; max-width: 80px;"></div>
              <h2 class="name">Shin Minhyuk</h2>
              <p class="title">Cinematographer / Photographer</p>
            </div>
            <div class="hero">
              <img src="/img/min.jpg" alt="avatar">
            </div>
          </div>

          <div class="slide-col">
            <div class="content">
              <p>Charlie Green is an European entrepreneur and media consultant, and investor. He is the
                founder of the Hallmark Inc.</p>
              <div style="border-bottom: 3px solid #898989; max-width: 80px;"></div>
              <h2 class="name">Charles Jayson</h2>
              <p class="title">Hallmark Inc.</p>
            </div>
            <div class="hero">
              <img src="https://user-images.githubusercontent.com/13468728/234031646-10533999-39e5-4c7b-ab54-d0299b13ce74.jpg" alt="avatar">
            </div>
          </div>

          <div class="slide-col">
            <div class="content">
              <p>Sarah Dam is an American internet entrepreneur and media proprietor, and investor. She is
                the founder of the multi-national technology company Zara.</p>
              <div style="border-bottom: 3px solid #898989; max-width: 80px;"></div>
              <h2 class="name">Sarah</h2>
              <p class="title">Zara Inc.</p>
            </div>
            <div class="hero">
              <img src="https://github.com/ecemgo/ecemgo/assets/13468728/55116c98-5f9a-4b0a-9fdb-4911b52d5ef3" alt="avatar">
            </div>
          </div>

        </div>
      </div>

      <div class="indicator mb-50">
        <span class="custom-btn active"></span>
        <span class="custom-btn"></span>
        <span class="custom-btn"></span>
        <span class="custom-btn"></span>
      </div>
    </main>
  </div>
  <!-- Testimonial End -->

  <div>


  </div>

  <script src="/js/combined.js"></script>


  <!-- JavaScript for Testimonial Section -->
  <script>
    const btns = document.querySelectorAll(".custom-btn");
    const slideRow = document.getElementById("slide-row");
    const main = document.querySelector("main");

    let currentIndex = 0;

    function updateSlide() {
      const mainWidth = main.offsetWidth;
      const translateValue = currentIndex * -mainWidth;
      slideRow.style.transform = `translateX(${translateValue}px)`;

      btns.forEach((btn, index) => {
        btn.classList.toggle("active", index === currentIndex);
      });
    }

    btns.forEach((btn, index) => {
      btn.addEventListener("click", () => {
        currentIndex = index;
        updateSlide();
      });
    });

    window.addEventListener("resize", () => {
      updateSlide();
    });
  </script>
  @endsection
  @yield('includes.footer')