@extends('layout.main-side')

@section('content')
<title>Admin - All Students</title>

<div class="sidetoppadding">
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-users"></i> All Students</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable12345" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Account Creation Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{$student->name}}</td>
                            <td>{{$student->email}}</td>
                            <td>{{$student->created_at->format('F d, Y')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection