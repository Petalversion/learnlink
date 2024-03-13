@extends('layout.main-side')

@section('content')
<title>Admin List</title>

<div class="sidetoppadding">
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-user-tie"></i> All Admin Accounts</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="table-responsive">
                <table id="myTable12345" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Account Creation Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{$admin->email}}</td>
                            <td>{{$admin->created_at->format('F d, Y')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection