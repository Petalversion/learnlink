@extends('layout.main-side')

@section('content')
<title>{{$name}} - Change Password</title>

<!-- End of Topbar -->
<div class="sidetoppadding" style="display: flex; justify-content: center;">

    <h1 class="h3 text-gray-800"><i class="fa-solid fa-key"></i> Change Password</h1>
</div>
<div class="sidetoppadding" style="margin-top:0px;margin-bottom:0px;display: flex; justify-content: center;">
    @if(session('success'))
    <div class="alert alert-success" style="width:600px;">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger" style="width:600px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" style="width:600px;">
        {{ session('error') }}
    </div>
    @endif
</div>
<div class="sidetoppadding" style="margin-top:0px;display: flex; justify-content: center;">
    <div class="card shadow" style="width:600px;">
        <div class=" card-body">
            <div class="container">
                <form class="row gutters" action="{{ route('student.change') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="card-body">
                            <div class="account-settings">
                                <div class="user-profile">
                                    <div class="user-avatar">
                                        @if(isset($user_info) && $user_info->profile_picture)
                                        <img class="rounded-circle" src="{{ asset('storage/' . $user_info->profile_picture) }}" alt="Profile Picture">
                                        @else
                                        <img src="/img/9131529.png" alt="Profile Picture">
                                        @endif
                                    </div>
                                    <div class="col-xl-12">
                                        <h6 class="mb-3 text-primary" style="font-size: 20px;">Change Password</h6>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label for="oldPassword">Old Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Old Password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label for="newPassword">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                                            <input type="password" class="form-control mt-2" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary" onclick="submitPassword()" id="cpass">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function submitPassword() {
        event.preventDefault();
        var passwordform = document.getElementById('passwordForm');
        if (!passwordform.submitting) {
            passwordform.submitting = true;
            document.getElementById('cpass').innerText = 'Changing...';
            document.getElementById('cpass').setAttribute('disabled', 'disabled'); // Disable the button
            passwordform.submit();
        }
    }
</script>
@endsection