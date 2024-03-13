@extends('layout.main-side')

@section('content')
<title>Admin - Terms and Condition</title>

<!-- End of Topbar -->
<div class="sidetoppadding">
    <h1 class="h3 mb-3 text-gray-800"><i class="fa-solid fa-user"></i> Terms and Condition</h1>
    <!-- Page Heading -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container">
                <form class="row gutters" action="{{ route('toc.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea id="toc" name="toc">{{ old('toc', optional($toc)->content) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="text-right">
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#toc'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            },

            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection