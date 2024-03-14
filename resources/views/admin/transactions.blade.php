@extends('layout.main-side')

@section('content')
<title>Admin - Transactions History</title>

<div class="sidetoppadding">
    <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-exchange"></i> Transactions</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable12345" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Transaction ID</th>
                            <th class="text-center">Purchase Date</th>
                            <th class="text-center">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            @php
                            $student_name = \App\Models\Student::where('student_id', $transaction->student_id)->first();
                            @endphp
                            <td style="vertical-align: middle;">{{$student_name->name}}</td>
                            <td class="text-center" style="vertical-align: middle;">{{$transaction->transaction_id}}</td>
                            <td class="text-center" style="vertical-align: middle;">{{$transaction->created_at->format('F d, Y')}}</td>
                            <td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-pill btn-primary" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fa fa-eye" aria-hidden="true"></i></button></td>
                        </tr>
                        <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex justify-content-center">
                                            <h5>Transaction ID: {{$transaction->transaction_id}} </h5>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach($transaction->course_id_amount as $courses)
                                        @php
                                        $course = \App\Models\Course::where('course_id', $courses['course_id'])->first();
                                        @endphp
                                        <div class="card mb-3" style="background-color:#e2e2e2">
                                            <div class="card-body">
                                                @if($course)
                                                <p class="small">{{ $course->title }}</p>
                                                @endif
                                                <p class="small text-bold text-end">₱ {{number_format($courses['amount'],2)}}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="d-flex justify-content-center">
                                            <h5>Total Price: ₱ {{ number_format($transaction->total_amount, 2, '.', ',') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
</div>



@endsection