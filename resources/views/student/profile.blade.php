@extends('layout.main-side')

@section('content')
<title>{{$name}} - Profile</title>

<!-- End of Topbar -->
<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container">
                <form class="row gutters" action="{{ route('student.profileupdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
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
                                    <h6 class="mb-3 text-primary" style="font-size: 20px;">Upload:</h6>
                                    <input type="file" name="profile_picture" accept=".jpeg, .jpg, .png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="mb-3 text-primary" style="font-size: 20px;">Personal Details</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="fullName">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($user_info)->student ? $user_info->student->name : '') }}" placeholder="">
                                        </div>
                                    </div>
                                    <!-- <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="phone">Bio</label>
                                                <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio', optional($user_info)->bio) }}">
                                            </div>
                                        </div> -->
                                    <h6 class="mb-3 text-primary" style="font-size: 20px;">Payment Methods</h6>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Gcash</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+63</span>
                                                <input type="text" class="form-control" id="gcash" name="gcash" value="{{ old('gcash', optional($user_info)->gcash) }}" pattern="[0-9]{10,}" title="Please enter a valid phone number" placeholder="Enter your Gcash Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Paypal</label>
                                            <input type="text" class="form-control" id="paypal" name="paypal" value="{{ old('paypal', optional($user_info)->paypal) }}" placeholder="Enter your Paypal Email Address">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="text-right">
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
@endsection