<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="/css/learn_style.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@v1.2.22/dist/iconify.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha384-HCEG3g6jvjvZt2KqF+fKT6vBYyZbMKgF8U3J0Onh5r9bsNymU7zkJ4jCCyCtq2sX" crossorigin="anonymous">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/fontawesome.min.css" rel="stylesheet" type="text/css" />
  <link href="css/owl.carousel.min.css" rel="stylesheet" type="text/css" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />

  <style>
    /*CSS for nav bar*/
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 15px;
      margin: 0;
    }

    .nav {
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
      -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      padding-left: 0;
      margin-bottom: 0;
      list-style: none;
    }

    .nav-link {
      display: block;
      padding: 0.5rem 1rem;
    }

    .nav-link:hover,
    .nav-link:focus {
      text-decoration: none;
    }

    .nav-link.disabled {
      color: #6c757d;
    }

    .nav-tabs {
      border-bottom: 1px solid #dee2e6;
    }

    .nav-tabs .nav-item {
      margin-bottom: -1px;
    }

    .nav-tabs .nav-link {
      border: 1px solid transparent;
      border-top-left-radius: 0.25rem;
      border-top-right-radius: 0.25rem;
    }

    .nav-tabs .nav-link:hover,
    .nav-tabs .nav-link:focus {
      border-color: #e9ecef #e9ecef #dee2e6;
    }

    .nav-tabs .nav-link.disabled {
      color: #6c757d;
      background-color: transparent;
      border-color: transparent;
    }

    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
      color: #495057;
      background-color: rgba(240, 234, 234, 0.048);
      border-color: #dee2e6 #dee2e6 rgba(240, 234, 234, 0.048);
    }

    .nav-tabs .dropdown-menu {
      margin-top: -1px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .navbar-light .navbar-nav .nav-link.dropdown-toggle {
      display: flex;
      align-items: center;
      margin-top: 5px;
    }

    .navbar-light .navbar-nav .nav-link.dropdown-toggle i.bx.bx-list-ul {
      font-size: 1.5rem;
      /* Adjust the size as needed */
      margin-top: -2px;
    }

    .nav-pills .nav-link {
      border-radius: 0.25rem;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
      color: #fff;
      background-color: #007bff;
    }

    .nav-fill .nav-item {
      -webkit-box-flex: 1;
      -webkit-flex: 1 1 auto;
      -ms-flex: 1 1 auto;
      flex: 1 1 auto;
      text-align: center;
    }

    .nav-justified .nav-item {
      -webkit-flex-basis: 0;
      -ms-flex-preferred-size: 0;
      flex-basis: 0;
      -webkit-box-flex: 1;
      -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
      flex-grow: 1;
      text-align: center;
    }

    .tab-content>.tab-pane {
      display: none;
    }

    .tab-content>.active {
      display: block;
    }

    .navbar {
      position: relative;
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
      -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -webkit-align-items: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -webkit-justify-content: space-between;
      -ms-flex-pack: justify;
      justify-content: space-between;
      padding: 0.5rem 1rem;
    }

    .navbar>.container,
    .navbar>.container-fluid {
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
      -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -webkit-align-items: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -webkit-justify-content: space-between;
      -ms-flex-pack: justify;
      justify-content: space-between;
    }

    .navbar-brand {
      display: inline-block;
      padding-top: 0.3125rem;
      padding-bottom: 0.3125rem;
      margin-right: 1rem;
      font-size: 1.25rem;
      line-height: inherit;
      white-space: nowrap;
    }

    .navbar-brand:hover,
    .navbar-brand:focus {
      text-decoration: none;
    }

    .navbar-nav {
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -webkit-flex-direction: column;
      -ms-flex-direction: column;
      flex-direction: column;
      padding-left: 0;
      margin-bottom: 0;
      list-style: none;
    }

    .navbar-nav .nav-link {
      padding-right: 0;
      padding-left: 0;
    }

    .navbar-nav .dropdown-menu {
      position: static;
      float: none;
    }

    .navbar-text {
      display: inline-block;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
    }

    .navbar-collapse {
      -webkit-flex-basis: 100%;
      -ms-flex-preferred-size: 100%;
      flex-basis: 100%;
      -webkit-box-flex: 1;
      -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
      flex-grow: 1;
      -webkit-box-align: center;
      -webkit-align-items: center;
      -ms-flex-align: center;
      align-items: center;
    }

    .navbar-toggler {
      padding: 0.25rem 0.75rem;
      font-size: 1.25rem;
      line-height: 1;
      background-color: transparent;
      border: 1px solid transparent;
      border-radius: 0.25rem;
    }

    .navbar-toggler:hover,
    .navbar-toggler:focus {
      text-decoration: none;
    }

    .navbar-toggler:not(:disabled):not(.disabled) {
      cursor: pointer;
    }

    .navbar-toggler-icon {
      display: inline-block;
      width: 1.5em;
      height: 1.5em;
      vertical-align: middle;
      content: "";
      background: no-repeat center center;
      -webkit-background-size: 100% 100%;
      background-size: 100% 100%;
    }

    @media (max-width: 575.98px) {

      .navbar-expand-sm>.container,
      .navbar-expand-sm>.container-fluid {
        width: 100%;
        padding-right: 0;
        padding-left: 0;
      }
    }

    @media (min-width: 576px) {
      .navbar-expand-sm {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-flow: row nowrap;
        -ms-flex-flow: row nowrap;
        flex-flow: row nowrap;
        -webkit-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
      }

      .navbar-expand-sm .navbar-nav {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
      }

      .navbar-expand-sm .navbar-nav .dropdown-menu {
        position: absolute;
      }

      .navbar-expand-sm .navbar-nav .nav-link {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
      }

      .navbar-expand-sm>.container,
      .navbar-expand-sm>.container-fluid {
        -webkit-flex-wrap: nowrap;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
      }

      .navbar-expand-sm .navbar-collapse {
        display: -webkit-box !important;
        display: -webkit-flex !important;
        display: -ms-flexbox !important;
        display: flex !important;
        -webkit-flex-basis: auto;
        -ms-flex-preferred-size: auto;
        flex-basis: auto;
      }

      .navbar-expand-sm .navbar-toggler {
        display: none;
      }
    }

    @media (max-width: 767.98px) {

      .navbar-expand-md>.container,
      .navbar-expand-md>.container-fluid {
        padding-right: 0;
        padding-left: 0;
      }
    }

    @media (min-width: 768px) {
      .navbar-expand-md {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-flow: row nowrap;
        -ms-flex-flow: row nowrap;
        flex-flow: row nowrap;
        -webkit-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
      }

      .navbar-expand-md .navbar-nav {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
      }

      .navbar-expand-md .navbar-nav .dropdown-menu {
        position: absolute;
      }

      .navbar-expand-md .navbar-nav .nav-link {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
      }

      .navbar-expand-md>.container,
      .navbar-expand-md>.container-fluid {
        -webkit-flex-wrap: nowrap;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
      }

      .navbar-expand-md .navbar-collapse {
        display: -webkit-box !important;
        display: -webkit-flex !important;
        display: -ms-flexbox !important;
        display: flex !important;
        -webkit-flex-basis: auto;
        -ms-flex-preferred-size: auto;
        flex-basis: auto;
      }

      .navbar-expand-md .navbar-toggler {
        display: none;
      }
    }

    @media (max-width: 991.98px) {

      .navbar-expand-lg>.container,
      .navbar-expand-lg>.container-fluid {
        padding-right: 0;
        padding-left: 0;
      }
    }

    @media (min-width: 992px) {
      .navbar-expand-lg {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-flow: row nowrap;
        -ms-flex-flow: row nowrap;
        flex-flow: row nowrap;
        -webkit-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
      }

      .navbar-expand-lg .navbar-nav {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
      }

      .navbar-expand-lg .navbar-nav .dropdown-menu {
        position: absolute;
      }

      .navbar-expand-lg .navbar-nav .nav-link {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
      }

      .navbar-expand-lg>.container,
      .navbar-expand-lg>.container-fluid {
        -webkit-flex-wrap: nowrap;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
      }

      .navbar-expand-lg .navbar-collapse {
        display: -webkit-box !important;
        display: -webkit-flex !important;
        display: -ms-flexbox !important;
        display: flex !important;
        -webkit-flex-basis: auto;
        -ms-flex-preferred-size: auto;
        flex-basis: auto;
      }

      .navbar-expand-lg .navbar-toggler {
        display: none;
      }
    }

    @media (max-width: 1199.98px) {

      .navbar-expand-xl>.container,
      .navbar-expand-xl>.container-fluid {
        padding-right: 0;
        padding-left: 0;
      }
    }

    @media (min-width: 1200px) {
      .navbar-expand-xl {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-flow: row nowrap;
        -ms-flex-flow: row nowrap;
        flex-flow: row nowrap;
        -webkit-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
      }

      .navbar-expand-xl .navbar-nav {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
      }

      .navbar-expand-xl .navbar-nav .dropdown-menu {
        position: absolute;
      }

      .navbar-expand-xl .navbar-nav .nav-link {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
      }

      .navbar-expand-xl>.container,
      .navbar-expand-xl>.container-fluid {
        -webkit-flex-wrap: nowrap;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
      }

      .navbar-expand-xl .navbar-collapse {
        display: -webkit-box !important;
        display: -webkit-flex !important;
        display: -ms-flexbox !important;
        display: flex !important;
        -webkit-flex-basis: auto;
        -ms-flex-preferred-size: auto;
        flex-basis: auto;
      }

      .navbar-expand-xl .navbar-toggler {
        display: none;
      }
    }

    .navbar-expand {
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
      -webkit-flex-flow: row nowrap;
      -ms-flex-flow: row nowrap;
      flex-flow: row nowrap;
      -webkit-box-pack: start;
      -webkit-justify-content: flex-start;
      -ms-flex-pack: start;
      justify-content: flex-start;
    }

    .navbar-expand>.container,
    .navbar-expand>.container-fluid {
      padding-right: 0;
      padding-left: 0;
    }

    .navbar-expand .navbar-nav {
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
      -webkit-flex-direction: row;
      -ms-flex-direction: row;
      flex-direction: row;
    }

    .navbar-expand .navbar-nav .dropdown-menu {
      position: absolute;
    }

    .navbar-expand .navbar-nav .nav-link {
      padding-right: 0.5rem;
      padding-left: 0.5rem;
    }

    .navbar-expand>.container,
    .navbar-expand>.container-fluid {
      -webkit-flex-wrap: nowrap;
      -ms-flex-wrap: nowrap;
      flex-wrap: nowrap;
    }

    .navbar-expand .navbar-collapse {
      display: -webkit-box !important;
      display: -webkit-flex !important;
      display: -ms-flexbox !important;
      display: flex !important;
      -webkit-flex-basis: auto;
      -ms-flex-preferred-size: auto;
      flex-basis: auto;
    }

    .navbar-expand .navbar-toggler {
      display: none;
    }

    .navbar-light .navbar-brand {
      color: rgba(0, 0, 0, 0.9);
    }

    .navbar-light .navbar-brand:hover,
    .navbar-light .navbar-brand:focus {
      color: rgba(0, 0, 0, 0.9);
    }

    .navbar-light .navbar-nav .nav-link {
      color: rgba(0, 0, 0, 0.5);
    }

    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link:focus {
      color: rgba(0, 0, 0, 0.7);
    }

    .navbar-light .navbar-nav .nav-link.disabled {
      color: rgba(0, 0, 0, 0.3);
    }

    .navbar-light .navbar-nav .show>.nav-link,
    .navbar-light .navbar-nav .active>.nav-link,
    .navbar-light .navbar-nav .nav-link.show,
    .navbar-light .navbar-nav .nav-link.active {
      color: rgba(0, 0, 0, 0.9);
    }

    .navbar-light .navbar-toggler {
      color: rgba(0, 0, 0, 0.5);
      border-color: rgba(0, 0, 0, 0.1);
    }

    .navbar-light .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar-light .navbar-text {
      color: rgba(0, 0, 0, 0.5);
    }

    .navbar-light .navbar-text a {
      color: rgba(0, 0, 0, 0.9);
    }

    .navbar-light .navbar-text a:hover,
    .navbar-light .navbar-text a:focus {
      color: rgba(0, 0, 0, 0.9);
    }

    .navbar-dark .navbar-brand {
      color: #fff;
    }

    .navbar-dark .navbar-brand:hover,
    .navbar-dark .navbar-brand:focus {
      color: #fff;
    }

    .navbar-dark .navbar-nav .nav-link {
      color: rgba(255, 255, 255, 0.5);
    }

    .navbar-dark .navbar-nav .nav-link:hover,
    .navbar-dark .navbar-nav .nav-link:focus {
      color: rgba(255, 255, 255, 0.75);
    }

    .navbar-dark .navbar-nav .nav-link.disabled {
      color: rgba(255, 255, 255, 0.25);
    }

    .navbar-dark .navbar-nav .show>.nav-link,
    .navbar-dark .navbar-nav .active>.nav-link,
    .navbar-dark .navbar-nav .nav-link.show,
    .navbar-dark .navbar-nav .nav-link.active {
      color: #fff;
    }

    .navbar-dark .navbar-toggler {
      color: rgba(255, 255, 255, 0.5);
      border-color: rgba(255, 255, 255, 0.1);
    }

    .navbar-dark .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar-dark .navbar-text {
      color: rgba(255, 255, 255, 0.5);
    }

    .navbar-dark .navbar-text a {
      color: #fff;
    }

    .navbar-dark .navbar-text a:hover,
    .navbar-dark .navbar-text a:focus {
      color: #fff;
    }




    /*Card*/
    #card {
      margin-top: 20px;
      padding: 0 20px;
    }

    #cardTitle {
      font-size: 24px;
    }

    #cardLayout {
      margin-top: 10px;
      width: 100%;
      display: flex;
      flex-wrap: wrap;
    }

    .cardContent {
      display: flex;
      align-items: center;
      border-style: solid;
      border-color: rgb(200, 200, 200);
      border-width: 1px;
      border-radius: 1px;
      height: 62px;
      padding: 0 15px;
      width: 27%;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .cardContent:hover {
      cursor: pointer;
      box-shadow: 0 0 0 5px rgba(0, 0, 0, 0.03);
    }

    .cardIcon {
      height: 32px;
      margin-right: 15px;
    }

    #cardDev {
      margin-right: 3%;
      margin-bottom: 10px;
    }

    #cardBus {
      margin-right: 3%;
    }

    #cardDes {
      margin-right: 3%;
      margin-bottom: 10px;
    }

    #cardMar {
      margin-right: 3%;
    }

    #cardPho {
      margin-right: 3%;
    }

    /*Footer*/
    #footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgb(247, 248, 250);
      margin-top: 20px;
      padding: 0 20px 0 0;
    }

    .footDiv {
      display: flex;
      height: 100%;
      align-items: center;
    }

    #footCop {
      font-size: 10px;
      color: rgb(104, 111, 122);
    }

    .footText {
      font-size: 10px;
      color: rgb(0, 119, 145);
      text-decoration: none;
    }

    .footText:hover {
      color: rgb(0, 50, 61);
    }

    #footTerm {
      margin-right: 10px;
    }

    /*CSS for responsive*/
    @media (max-width: 825px) {
      .cardContent {
        width: 42%;
      }

      #cardBus {
        margin-right: 0;
      }

      #cardIT {
        margin-right: 3%;
      }

      #cardDes {
        margin-right: 0;
      }

      #cardMar {
        margin-bottom: 10px;
      }
    }

    @media (max-width: 650px) {
      .navBig {
        display: none;
      }

      .navSmall {
        display: flex;
      }

      #searchIcon {
        height: 20px;
      }

      #cart {
        height: 35px;
      }

      .navDiv {
        width: 33.33333333%;
      }

      #bannerTitle {
        font-size: 30px;
      }

      #bannerBody {
        font-size: 13px;
      }

      .bannerText {
        width: 210px;
      }
    }

    @media(max-width: 570px) {
      .cardContent {
        width: 100%;
      }

      #cardDev {
        margin-right: 0;
      }

      #cardBus {
        margin-bottom: 10px;
      }

      #cardIT {
        margin-right: 0;
        margin-bottom: 10px;
      }

      #cardMar {
        margin-right: 0;
      }

      #cardPho {
        margin-top: 10px;
        margin-bottom: 10px;
        margin-right: 0;
      }
    }

    @media(max-width: 375px) {
      #bannerSearch {
        width: 100%;
      }
    }

    @media(max-width: 250px) {
      .bannerText {
        width: 100%;
      }
    }

    .carousel-inner img {
      width: 100%;
      height: auto;
    }

    .gtco-testimonials {
      position: relative;
      margin-top: 30px;

      h2 {
        font-size: 30px;
        text-align: center;
        color: #333333;
        margin-bottom: 50px;
      }

      .owl-stage-outer {
        padding: 30px 0;
      }

      .owl-nav {
        display: none;
      }

      .owl-dots {
        text-align: center;

        span {
          position: relative;
          height: 10px;
          width: 10px;
          border-radius: 50%;
          display: block;
          background: #fff;
          border: 2px solid #01b0f8;
          margin: 0 5px;
        }

        .active {
          box-shadow: none;

          span {
            background: #01b0f8;
            box-shadow: none;
            height: 12px;
            width: 12px;
            margin-bottom: -1px;
          }
        }
      }

      .card {
        background: #fff;
        box-shadow: 0 8px 30px -7px #c9dff0;
        margin: 0 20px;
        padding: 0 10px;
        border-radius: 20px;
        border: 0;

        .card-img-top {
          max-width: 100px;
          border-radius: 50%;
          margin: 15px auto 0;
          box-shadow: 0 8px 20px -4px #95abbb;
          width: 100px;
          height: 100px;
        }

        h5 {
          color: #01b0f8;
          font-size: 21px;
          line-height: 1.3;

          span {
            font-size: 18px;
            color: #666666;
          }
        }

        p {
          font-size: 18px;
          color: #555;
          padding-bottom: 15px;
        }
      }

      .active {
        opacity: 0.5;
        transition: all 0.3s;
      }

      .center {
        opacity: 1;

        h5 {
          font-size: 24px;

          span {
            font-size: 20px;
          }
        }

        .card-img-top {
          max-width: 100%;
          height: 120px;
          width: 120px;
        }
      }
    }

    @media (max-width: 767px) {
      .gtco-testimonials {
        margin-top: 20px;
      }
    }

    .owl-carousel {
      .owl-nav button {

        &.owl-next,
        &.owl-prev {
          outline: 0;
        }
      }

      button.owl-dot {
        outline: 0;
      }
    }

    .btn-hover-effect:hover {
      transform: scale(1.05);
      /* Increase size on hover */
    }
  </style>


  <title>Video Courses</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <a class="navbar-brand mb-3" href="#">
      <img src="images/logo-coral.svg" width="100px">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">


      <ul class="navbar-nav mr-auto container-fluid">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-list-ul"></i> Categories
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>

        <li class="nav-item col-12">
          <form class="form-inline ml-3 my-2 my-lg-0 inbutton">
            <div class="input-group">
              <input class="form-control form-control-lg bg-light border-0" style="border-radius: 5px 0 0 5px"
                type="search" placeholder="Search for Courses" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-light btn-lg my-sm-0 ml-0" style="border-radius: 0 5px 5px 0;" type="submit">
                  <i class="bx bx-search text-danger"></i>
                </button>
              </div>
            </div>
          </form>
        </li>


      </ul>

      <a class="nav-link btn btn-light  mx-2 my-2" href="#">Become an Instructor</a>
      <a class="nav-link btn btn-light  mx-2 my-2" href="#"> <i class="bx bx-cart cart font-weight-bold"></i> </a>
      <a class="nav-link btn btn-outline-dark mx-2 my2" href="#">Login</a>
      <a class="nav-link btn btn-danger mx-2 my-2" href="#">Signup</a>

    </div>
  </nav>



  <section>
    <h2 class="title">Courses</h2>
    <div class="container">
      <div id="video_player">
        <iframe controls id="main-Video" src="" frameborder="0"></iframe>
      </div>
      <div class="playlistBx">
        <div class="header">
          <div class="row">
            <span class="AllLessons"></span>
          </div>
        </div>
        <ul class="playlist" id="playlist">
        </ul>
      </div>
    </div>

    <br>

    <div class="container">

      <div class="section-title">
        <h2>Description About the Course</h2>
        <p> As an IT student with a passion for technology and a desire to learn and grow in the field, I am excited to
          seek
          an on-the-job training opportunity that will allow me to apply my academic knowledge to real-world scenarios
          and gain practical experience. I am a quick learner and have excellent problem-solving skills, which enable me
          to adapt to new technologies and work efficiently in a fast-paced environment. Moreover, I have excellent
          communication and collaboration skills, which allow me to work well with others and contribute to team
          projects
          effectively.</p>
      </div>


  </section>

  <div class="container mt-5 d-flex justify-content-center">

    <div class="card p-3">

      <div class="d-flex align-items-left">

        <div class="image">
          <img
            src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80"
            class="rounded" width="155">
        </div>

        <div class="ml-3 w-100">

          <h4 class="mb-0 mt-0">Bello Bambino</h4>
          <span>IT Professor</span>






          <script src="/js/learn_video-list.js"></script>
          <script src="/js/learn_script.js"></script>





</body>

</html>