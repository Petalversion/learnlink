<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>Password Reset</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .container {
            height: 100vh;
        }
    </style>

</head>

<body>

    <div class="bg-gradient-info ">

        <div class="container d-flex justify-content-center align-items-center">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 ">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block">
                                    <img class="img-fluid mt-4" src="/img/log.png" alt="image">
                                </div>
                                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                    <div class="p-4">
                                        @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif
                                        @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif
                                        <div class="nk-nav-logo text-center mb-3">
                                            <a href="{{ route('index') }}" class="nk-nav-logo">
                                                <img src="/img/blcck.png" alt="" width="120">
                                            </a>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Reset your Password</h1>
                                        </div>
                                        <form class="user" id="loginForm" action="{{ route('instructor.reset') }}" method="POST">
                                            @csrf
                                            @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul style="margin-bottom: 0;">
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <input class="form-control form-control-user mb-2" type="email" name="email" value="{{ $email }}" readonly>
                                                <input class="form-control form-control-user mb-2" type="password" name="password" placeholder="New Password" required>
                                                <input class="form-control form-control-user" type="password" name="password_confirmation" placeholder="Confirm New Password" required>
                                            </div>

                                            <a href="#" onclick="submitLoginForm()" class="btn btn-danger btn-user btn-block mt-2" id="loginBtn">
                                                Reset Password
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>
    <!-- Submit button -->
    <script>
        function submitLoginForm() {
            event.preventDefault();
            var form = document.getElementById('loginForm');
            if (!form.submitting) {
                form.submitting = true;
                document.getElementById('loginBtn').innerText = 'Resetting...';
                document.getElementById('loginBtn').setAttribute('disabled', 'disabled');
                form.submit();
            }
        }
    </script>

</body>

</html>