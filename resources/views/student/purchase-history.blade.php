@extends('layout.main-side')

@section('content')
<div class="container" style="padding-left: 250px; margin-top:5%;">
    @if(isset($transactions) && $transactions->isNotEmpty())
    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="table-responsive">

                <!-- Begin Page Content -->
                <div class="container mt-2">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th onclick="sortTable(0)" class="text-center" colspan="1">Reference #</th>
                                    <th colspan="1">Date</th>
                                    <th colspan="2">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <h2 class="text-primary" style="margin-bottom: 4%;">Purchase History</h2>
                                @foreach($transactions as $transaction)
                                <tr class="text-center hover-pointer" id="transaction-row-{{$transaction->transaction_id}}" onclick="toggleCourseDetails('{{$transaction->transaction_id}}')">
                                    <th class="bg-secondary" colspan=" 1">{{$transaction->transaction_id}}</th>
                                    <th class="bg-secondary" colspan=" 1">{{$transaction->created_at}}</th>
                                    <th class="text-end bg-secondary " colspan=" 1">₱</th>
                                    <th class="text-end bg-secondary " colspan=" 1"> {{number_format($transaction->total_amount,2)}}</th>
                                </tr>
                                @foreach($transaction->course_id_amount as $courses)
                                <tr class="text-end" id="course-details-{{$transaction->transaction_id}}-{{$loop->index}}" style="display: none;">
                                    <td colspan=" 2">
                                        @php
                                        $course = \App\Models\Course::where('course_id', $courses['course_id'])->first();
                                        @endphp
                                        @if($course)
                                        {{ $course->title }}
                                        @endif
                                    </td>
                                    <td colspan="2">
                                        {{number_format($courses['amount'],2)}}
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
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
                    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-center align-items-center">Your Do not have any Transactions</h6>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


@endsection