@extends('layout.main-side')

@section('content')
<div class="sidetoppadding">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-receipt"></i>Withdrawal History</h1>
        </div>
        <!-- <div class="col-md-6 text-md-right">
            <a href="{{ route('instructor.transactions.new') }}" class="btn btn-primary btn-icon-split p-0">
                <span class="icon text-white-50">
                    <i class="fas fa-circle-plus"></i>
                </span>
                <span class="text">Request</span>
            </a>
        </div> -->
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                @if(isset($withdrawals) && $withdrawals->isNotEmpty())
                <table class="table table-striped" id="myTable12345">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">Request Date</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Request #</th>
                            <th class="text-center">Reference #</th>
                            <th class="text-center">Wallet</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $withdrawal)
                        <tr class="text-center">
                            <td class="text-center">{{$withdrawal->created_at->format('F d, Y')}}</td>
                            <td>₱ {{number_format((($withdrawal->amount)*-1.00), 2, '.', ',')}}</td>
                            <td class="text-center">{{$withdrawal->request_id}}</td>
                            <td class="text-center">{{$withdrawal->reference_id}}</td>
                            <td class="text-center"><span class="badge badge-pill {{ $withdrawal->type === 'paypal' ? 'badge-warning' : 'badge-primary' }}">
                                    {{ $withdrawal->type === 'paypal' ? 'PayPal' : ($withdrawal->type === 'gcash' ? 'Gcash' : $withdrawal->type) }}
                                </span></td>
                            <td>
                                @if(is_null($withdrawal->reference_id))
                                <span class="badge badge-pill badge-secondary">Pending</span>
                                @else
                                <span class="badge badge-pill badge-success">Settled</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-center align-items-center">You have no Pending Withdrawals</h6>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection