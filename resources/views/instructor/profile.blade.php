@extends('layout.main-side')

@section('content')
<title>{{$name}} - Profile</title>

<!-- End of Topbar -->
<div class="sidetoppadding">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <h1 class="h3 mb-3 text-gray-800"><i class="fa-solid fa-user"></i> Profile</h1>
    <!-- Page Heading -->


    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="container">
                <form class="row gutters" action="{{ route('instructor.profileupdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                        <div class="card-body">
                            <div class="account-settings">
                                <div class="user-profile">
                                    <div class="user-avatar">
                                        @if(isset($instructor_info) && $instructor_info->profile_picture)
                                        <img class="rounded-circle" src="{{ asset('storage/' . $instructor_info->profile_picture) }}" alt="Profile Picture">
                                        @else
                                        <img src="/img/9131529.png" alt="Profile Picture">
                                        @endif
                                    </div>
                                    <h6 class="mb-3 text-primary" style="font-size: 20px;">Upload:</h6>
                                    <input class="form-control" type="file" name="profile_picture" accept=".jpeg, .jpg, .png">
                                </div>
                                <div class="col-xl-12">
                                    <h6 class="mb-3 text-primary" style="font-size: 20px;">Change Password</h6>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="oldPassword">Old Password</label>
                                        <input type="text" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old Password">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="text" class="form-control" id="newPassword" name="newPassword" placeholder="New Password">
                                        <input type="text" class="form-control mt-2" id="confirmnewPassword" name="confirmnewPassword" placeholder="Confirm New Password">
                                    </div>
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
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($instructor_info)->instructor ? $instructor_info->instructor->name : '') }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="phone">Bio</label>
                                            <textarea id="bio" name="bio">{{ old('bio', optional($instructor_info)->bio) }}</textarea>
                                        </div>
                                    </div>
                                    <h6 class="mb-3 text-primary" style="font-size: 20px;">Payment Methods</h6>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Gcash</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+63</span>
                                                <input type="text" class="form-control" id="gcash" name="gcash" value="{{ old('gcash', optional($instructor_info)->gcash) }}" pattern="[0-9]{10,}" title="Please enter a valid phone number" placeholder="Enter your Gcash Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Paypal</label>
                                            <input type="text" class="form-control" id="paypal" name="paypal" value="{{ old('paypal', optional($instructor_info)->paypal) }}" placeholder="Enter your Paypal Email Address">
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#bio'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            },

            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection