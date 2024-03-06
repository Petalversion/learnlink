@extends('layout.main-side')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">

    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-users"></i> All Instructors</h1>

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
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instructors as $instructor)
                        <tr>
                            <td>{{$instructor->name}}</td>
                            <td>{{$instructor->email}}</td>
                            <td>{{$instructor->created_at->format('F d, Y')}}</td>
                            <td class="text-center">
                                @if($instructor->status == 'pending' || $instructor->status == 'Pending' )
                                <span class="badge badge-pill badge-secondary">{{$instructor->status}}</span>
                                @elseif($instructor->status == 'approved' || $instructor->status == 'Approved' )
                                <span class="badge badge-pill badge-success">{{$instructor->status}}</span>
                                @else
                                <span class="badge badge-pill badge-danger">{{$instructor->status}}</span>
                                @endif
                            </td>
                            <td class="text-center"><button type="button" class="badge badge-pill badge-primary" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fa fa-eye" aria-hidden="true"></i></button></td>
                        </tr>
                        <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex justify-content-center">
                                            <h5>STATUS</h5>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('update-status') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" value="{{$instructor->instructor_id}}" name="instructor_id">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group" data-toggle="buttons">
                                                    @foreach(['Pending' => 'secondary', 'Approved' => 'success', 'Declined' => 'danger'] as $type => $color)
                                                    <div class="btn-group px-1" role="group">
                                                        <label class="btn btn-outline-{{ $color }} rounded-pill">
                                                            <input type="radio" name="type" value="{{ $type }}" {{old('type', $instructor->status) === $type ? 'checked' : '' }}> {{ $type }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="text-center mt-3">
                                                <button type="submit" name="Update" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
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