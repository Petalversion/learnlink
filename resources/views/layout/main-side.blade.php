<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('links.sidebar-links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/favicon.png">


    <style>
        .quiz_box {
            width: 60%;
            margin: 0 auto;
        }

        .result_box {
            width: 80%;
            margin: 0 auto;
        }

        .quiz_box header .time_line {
            display: none;
        }

        .navbar-nav>.nk-nav-logo {
            padding: 15px 0px;
            display: flex;
            justify-content: center;
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            .info_box {
                width: 75%;
            }

            .quiz_box {
                width: 95%;
            }


            .quiz_box section .que_text {
                font-size: 15px !important;
            }

            .quiz_box section .option {
                font-size: 12px !important;
            }

            .quiz_box header .time_left_txt,
            .timer_sec {
                font-size: 15px !important;
            }

        }


        @media only screen and (max-width: 425px) {
            .navbar-nav {
                display: none;
            }

            /* .showSideBar {
                display: block;
            } */

            .sidetoppadding {
                padding-left: 15px;
            }

            #sidebarToggleTop {
                margin-left: 10px;
            }


        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggleTop = document.querySelector('#sidebarToggleTop');
            const navbarNav = document.querySelector('.navbar-nav');
            const sideTopPadding = document.querySelector('.sidetoppadding');

            sidebarToggleTop.addEventListener('click', function() {
                if (navbarNav.style.display === 'none') {
                    navbarNav.style.display = 'block';
                    sidebarToggleTop.style.marginLeft = "105px";
                } else {
                    sidebarToggleTop.style.marginLeft = "10px";
                    navbarNav.style.display = 'none';
                }
            });

        });
    </script>
</head>


<body style="background-color: #fff;">
    @include('includes.sidebar')
    @include('script-js.sidebar-script')
</body>

</html>