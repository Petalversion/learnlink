@extends('layout.main-side')

@section('content')
<title>Admin - Categories</title>

<div class="sidetoppadding">

    <div class="row">
        <div class="col-md-6">
            <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-list"></i> Categories</h1>
        </div>
        <div class="col-md-6 text-md-right mb-2">
            <a href="#" class="btn btn-primary btn-icon-split p-0" data-toggle="modal" data-target="#addNew">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Add New</span>
            </a>
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="d-flex justify-content-center">
                                <h5>Add a new Category:</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('categories.add') }}" method="POST" id="addNewForm">
                                @csrf
                                <input type="text" class="form-control" name="category" placeholder="Category Name...">
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary" id="addNewBtn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable12345" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Category Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{$category->name}}</td>
                            <td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-pill btn-primary" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fa fa-pen-to-square" aria-hidden="true"></i></button></td>
                        </tr>
                        <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex justify-content-center">
                                            <h5>Edit Category:</h5>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('categories.update') }}" method="POST" id="updateCategoryForm{{ $category->id }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="categoryid" value="{{$category->id}}">
                                            <input type="text" class="form-control" name="category" value="{{ old('category', $category->name) }}" placeholder="Category Name...">
                                            <div class="text-right mt-3">
                                                <button type="submit" class="btn btn-primary" onclick="updateCategory({{ $category->id }})" id="updateCategory_{{ $category->id }}">Update</button>
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
<script>
    function updateCategory(categoryId) {
        var updateBtn = document.getElementById('updateCategory_' + categoryId);
        updateBtn.setAttribute('disabled', 'true');
        updateBtn.innerText = 'Updating...';
        document.getElementById('updateCategoryForm' + categoryId).submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var addNewBtn = document.getElementById('addNewBtn');
        addNewBtn.addEventListener('click', function() {
            addNewBtn.setAttribute('disabled', 'true');
            addNewBtn.innerText = 'Submitting...';
            document.getElementById('addNewForm').submit();
        });
    });
</script>


@endsection