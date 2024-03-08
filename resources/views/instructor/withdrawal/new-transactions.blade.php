@extends('layout.main-side')

@section('content')

<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="sidetoppadding">

    <div class="col-md-6">
        <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-exchange"></i> Withdrawal Request</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="container mb-5 ">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="table-responsive">
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
                            <button type="submit" class="btn btn-primary" style="border-radius: 20px;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-3">Current Available Balance: {{$balance}}</h2>
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
</script>
@endsection