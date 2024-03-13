@extends('layout.main-side')

@section('content')
<title>Admin - Withdrawal Requests</title>

<!-- Begin Page Content -->
<div class="sidetoppadding">

    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-receipt"></i> Withdrawal Requests</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                @if(session('success'))
                <div class="alert alert-success">
                    {!! session('success') !!}
                </div>
                @endif
                <table id="myTable12345" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Request ID</th>
                            <th class="text-center">Withdrawal Method</th>
                            <th class="text-center">Details</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Request Date</th>
                            <th class="text-center">Receipt Number</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>

                            @php
                            $instructor_name = \App\Models\Instructor::where('instructor_id', $transaction->instructor_id)->first();
                            @endphp

                            <td>{{$instructor_name->name}}</td>
                            <td class="text-center">{{$transaction->request_id}}</td>
                            <td class="text-center"><span class="badge badge-pill {{ $transaction->type === 'paypal' ? 'badge-warning' : 'badge-primary' }}">
                                    {{ $transaction->type === 'paypal' ? 'PayPal' : ($transaction->type === 'gcash' ? 'Gcash' : $transaction->type) }}
                                </span></td>
                            @php
                            $payment_method = \App\Models\Instructor_info::where('instructor_id', $transaction->instructor_id)->first();
                            @endphp
                            <td>
                                @if($transaction->type == 'gcash')
                                0{{$payment_method->gcash}}
                                @elseif($transaction->type == 'paypal')
                                {{$payment_method->paypal}}
                                @endif
                            </td>
                            <td class="text-center">₱ {{number_format((($transaction->amount)*-1.00), 2, '.', ',')}}</td>
                            <td class="text-center">{{$transaction->created_at->format('F d, Y')}}</td>
                            <td class="text-center"><button type="button" class="badge badge-pill badge-primary" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fa fa-faw fa-receipt" aria-hidden="true"></i></button></td>
                            <td class="text-center">
                                @if(is_null($transaction->reference_id))
                                <span class="badge badge-pill badge-secondary">Pending</span>
                                @else
                                <span class="badge badge-pill badge-success">Settled</span>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex justify-content-center">
                                            <h5>Receipt Number:</h5>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.withdrawal.update') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="request_id" value="{{$transaction->request_id}}">
                                            <input type="text" class="form-control" name="reference_id" value="{{ old('reference_id', $transaction->reference_id) }}" placeholder="Receipt Number...">
                                            <div class="text-right mt-3">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
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