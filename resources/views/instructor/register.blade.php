<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Instructor - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    .container {
      height: 100vh;
      /* padding-top: 50px; */
    }

    .img-left {
      width: 110% !important;
      /* margin-top: 1.2rem; */
    }
  </style>

</head>

<body>
  <div class="bg-gradient-info">
    <div class="container d-flex justify-content-center align-items-center">

      <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body my-auto">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-5 d-none d-lg-block">
              <img class="img-left" src="/img/sir.png">
            </div>
            <div class="col-lg-7">
              <div class="p-3">
                <div class="nk-nav-logo text-center mb-3">
                  <a href="{{route('index')}}" class="nk-nav-logo">
                    <img src="/img/blcck.png" alt="" width="120">
                  </a>
                </div>
                <div class="text-center">
                  <h1 class="h5 text-gray-800 mb-4">Create an Account!</h1>
                </div>
                <form id="registrationForm" class="user" action="{{ route('instructor.register') }}" method="POST">
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
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email Address" value="{{ old('email') }}" required>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password" required>
                    </div>
                    <div class="col-sm-6">
                      <input type="password" class="form-control form-control-user" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password" required>
                    </div>
                  </div>
                  <input type="hidden" name="role" value="student">
                  <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
                    <label class="form-check-label" for="termsCheckbox">
                      <a href="#" id="termsLink" style="text-decoration:none;">Terms and
                        Conditions</a>
                    </label>
                  </div>
                  <a href="#" onclick="submitRegistration()" class="btn btn-primary btn-user btn-block" id="registerBtn">
                    Register
                  </a>
                  <a href="{{ route('student.register') }}" class="btn btn-secondary btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Register as Student
                  </a>
                </form>
                <!-- <hr> -->
                <div class="text-center">
                  <a class="small" href="{{ route('instructor.login') }}">Already have an account? Login!</a>
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
    function submitRegistration() {
      event.preventDefault();
      var form = document.getElementById('registrationForm');
      if (!form.submitting) {
        form.submitting = true;
        document.getElementById('registerBtn').innerText = 'Please wait...';
        document.getElementById('registerBtn').setAttribute('disabled', 'disabled');
        form.submit();
      }
    }
  </script>

</body>

</html>