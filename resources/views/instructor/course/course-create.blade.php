@extends('layout.main-side')

@section('content')


<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">

    <a href="{{ route('instructor.course.course') }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <!-- Page Heading -->

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <div class="container">
                    <h1>New Course</h1>
                    <form action="{{ route('instructor.course.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <input type="hidden" name="course_id" value="{{ session('course_id') }}">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="summary" class="form-label">Summary</label>
                                    <textarea id="summary" name="summary" class="form-control" rows="2" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Course
                                        Description</label>
                                    <textarea name="description" id="description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="wyl" class="form-label">What You'll
                                        Learn</label>
                                    <textarea name="wyl" id="wyl"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea name="requirements" id="requirements"></textarea>
                                </div>
                                <div class="container border p-3" style="border-radius: 15px;">
                                    <div class="mb-3">
                                        <label class="form-label">Difficulty</label><br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="beginner" name="difficulty" class="form-check-input" value="beginner" required>
                                            <label for="beginner" class="form-check-label">Beginner</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="intermediate" name="difficulty" class="form-check-input" value="intermediate" required>
                                            <label for="intermediate" class="form-check-label">Intermediate</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="expert" name="difficulty" class="form-check-input" value="expert" required>
                                            <label for="expert" class="form-check-label">Expert</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="container p-0 mt-3 mb-3" style="border-radius: 15px;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="submit" name="draft" value="1"
                                                    class="btn btn-secondary">Save as Draft</button> -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="container border p-3 mb-3" style="border-radius: 15px;">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                </div>

                                <hr>

                                <div class="container border p-3 mb-3" style="border-radius: 15px;">
                                    <div class="mb-3">
                                        <label for="tag" class="form-label">Tag</label>
                                        <!-- <div id="tags" class="form-check">
                                                            @foreach ($tags as $tag)
                                                            <span>{{$tag->name }}</span>
                                                            <input type="text" value="{{ $tag->id }}"
                                                                placeholder="Add a tag" name="tags[]" />
                                                            @endforeach
                                                        </div> -->
                                        @foreach ($tags as $tag)
                                        <div class="form-check">
                                            <input type="checkbox" id="tag_{{ $tag->id }}" name="tags[]" class="form-check-input" value="{{ $tag->id }}">
                                            <label for="tag_{{ $tag->id }}" class="form-check-label">{{
                                                                $tag->name }}</label>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>



                                <hr>
                                <div class="container border p-3" style="border-radius: 15px;">
                                    <h7>Course Type</h7>
                                    <hr>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" id="paid" name="paid" class="form-check-input" value="1">
                                        <label for="paid" class="form-check-label">Paid Course</label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="free" value="0">
                                        <input type="checkbox" id="free" name="free" class="form-check-input" value="1">
                                        <label for="free" class="form-check-label">Free Course</label>
                                    </div>

                                    <hr class="mt-4">
                                    <div class="mb-3 mt-4 input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" id="amount" name="amount" class="form-control" step="0.01" placeholder="Course Amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
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

    ClassicEditor
        .create(document.querySelector('#wyl'), {
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

    ClassicEditor
        .create(document.querySelector('#requirements'), {
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

<script>
    jQuery($ => { // DOM ready and $ alias in scope.

        // TAGS BOX
        $("#tags input").on({
            focusout() {
                var txt = this.value.replace(/[^a-z0-9\+\-\.\#]/ig, ''); // allowed characters
                if (txt) $("<span/>", {
                    text: txt.toLowerCase(),
                    insertBefore: this
                });
                this.value = "";
            },
            keyup(ev) {
                if (/(,|Enter)/.test(ev.key)) $(this).focusout();
            }
        });
        $("#tags").on("click", "span", function() {
            $(this).remove();
        });

    });
</script>