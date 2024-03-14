@extends('layout.main-side')

@section('content')
<title>{{$name}} - Withdrawal Request</title>

<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="sidetoppadding">

    <div class="container-fluid">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6 d-flex align-items-center ml-1">
                <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-exchange"></i> Withdrawal Request</h1>
            </div>
            <div class="col-xl-3 col-md-6 mb-3 justify-content-end">
                <div class="card border-left-success shadow h-100 py-2 px-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Available Balance</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$balance}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-peso-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 mb-4 withdrawal-request">

        <div class="card shadow mb-4">

            <div class="card-body ">

                <div class="table-responsive">
                    <div class="container-fluid mb-5 ">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="table-responsive pb-0">
                            <form action="{{ route('instructor.transactions.add') }}" method="POST" class="mt-5">
                                @csrf
                                <input type="number" id="maxValueInput" value="{{$balance}}" style="display: none;">
                                <input type="hidden" value="{{$instructor_info->instructor_id}}" name="instructor_id">

                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount (PHP) </label>
                                    <input type="number" id="title" name="amount" class="form-control" step="0.01" max="{{$balance}}">
                                </div>
                                <input type="radio" name="payment" value="gcash">
                                <label for="gcash">GCash (<strong>0{{$instructor_info->gcash}}</strong>)</label><br>
                                <input type="radio" name="payment" value="paypal">
                                <label for="paypal">PayPal (<strong>{{$instructor_info->paypal}}</strong>)</label><br>
                                <hr>
                                <button type="submit" class="btn btn-primary " style="border-radius: 20px;" id="submitBtn">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    document.getElementById('title').addEventListener('input', function() {
        var maxValueInput = document.getElementById('maxValueInput');
        var maxValue = parseFloat(maxValueInput.value);

        var currentValue = parseFloat(this.value);

        if (currentValue > maxValue) {
            this.value = maxValue.toFixed(2);
        }

        // Limiting to 2 decimal places
        var valueParts = this.value.split('.');
        if (valueParts.length > 1 && valueParts[1].length > 2) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('submitBtn').addEventListener('click', function() {
            this.setAttribute('disabled', 'true');
            this.innerText = 'Submitting...';
            document.querySelector('form').submit();
        });
    });
</script>
@endsection