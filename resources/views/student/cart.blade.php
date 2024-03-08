@extends('layout.main-side')

@section('content')
<title>My Cart</title>
<div class="sidetoppadding">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-900">My Cart</h1>
        <!-- Content Row -->
        @if(isset($cartItems) && $cartItems->isNotEmpty())
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Courses</h6>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div style="padding: 10px; margin-top: 10px;">
                        @foreach($cartItems as $cartItem)
                        @foreach ($cartItem->courses as $course)
                        <div class="container">
                            <div class="card mb-3">
                                <div class="row g-0 ">
                                    <div class="col-md-2 col-sm-12">
                                        <img src="{{ asset('storage/' . $course->image) }}" class="img-fluid rounded-start">
                                    </div>
                                    <div class="col-md-7 col-sm-12 d-flex align-items-center" style="padding: 10px;">
                                        <h4 class="clamped-line card-title" style="font-size: 15px;"><a href="{{route('course_details', $course->course_id)}}">{{ $course->title }}</a></h4>
                                    </div>
                                    <div class="col-md-2 col-sm-12 d-flex align-items-center">
                                        <h4 class="card-title" style="margin: 10px 0;">₱ {{ number_format($course->amount, 2, '.', ',') }} </h4>
                                    </div>
                                    <div class="col-md-1 col-sm-12 d-flex justify-content-center align-items-center">
                                        <form action="{{ route('cart.remove', $cartItem->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Checkout</h6>
                    </div>
                    <h3 style="padding-left: 5%; padding-top: 5%;">Total</h3>
                    <div class="d-flex justify-content-center">
                        <h1 class="card-title" style="margin: 10px 0;">₱ {{ number_format($total, 2, '.', ',') }}</h1>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <div>
                            <!-- Set up a container element for the button -->
                            <!-- <div id="paypal-button-container" style="min-width:100%;"></div> -->
                            <form action="{{route('paypal.pay')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$total}}" name="amount">
                                <button type="submit" class="btn btn-primary" style="margin-bottom:5%;border-radius: 20px; min-width:100%">PayPal</button>
                            </form>
                            <a href="{{route('gcash.pay')}}" class="btn btn-primary" style="border-radius: 20px; min-width:100%">Gcash</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-xl-12">
                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-center align-items-center">Your Cart is Empty</h6>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</div>
@endsection