@extends('layout.main-side')

@section('content')
<!-- Begin Page Content -->
<div class="sidetoppadding">
  <div class="card o-hidden border-0 shadow-lg">
    <div class="card-body my-auto">
      <div class="p-3">
        <div class="nk-nav-logo text-center mb-3">
          <img src="/img/blcck.png" alt="" width="120">
        </div>
        <div class="text-center">
          <h1 class="h5 text-gray-800 mb-4">New Admin</h1>
        </div>
        <form id="registrationForm" class="user" action="{{ route('admin.register') }}" method="POST">
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
            <input type="hidden" name="name" class="form-control form-control-user" id="name" placeholder="Email Address" value="Admin" required>
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
          <input type="hidden" name="role" value="admin">
          <a href="#" onclick="submitRegistration()" class="btn btn-primary btn-user btn-block">
            Register
          </a>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function submitRegistration() {
    var form = document.getElementById('registrationForm');
    form.submit();
  }
</script>
@endsection