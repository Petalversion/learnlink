@extends('layout.main-side')

@section('content')
<title>{{$name}} - New Course</title>

<style>
    .tags-input {
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
        display: inline-flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .tags {
        background-color: #007bff;
        color: white;
        padding: 3px 10px;
        border-radius: 50px;
        margin-right: 5px;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }

    .tag-input {
        border: none;
        outline: none;
        margin: 5px;
    }

    .fa-circle-xmark {
        margin-left: 10px;
        cursor: pointer;
    }
</style>

<div class="sidetoppadding">

    <a href="{{ route('instructor.course.course') }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <!-- Page Heading -->

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <div class="container">
                    <h1>New Course</h1>
                    <form action="{{ route('instructor.course.store') }}" method="POST" enctype="multipart/form-data" id="course-form">
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
                                <div class="container border p-3 mb-3" style="border-radius: 15px;">
                                    <div class="mb-3">
                                        <label for="select" class="form-label">Category</label>
                                        <select class="form-select" name="category">
                                            <option value="" selected disabled>--Select Category--</option>
                                            @foreach ($categories as $category)
                                            <option value="{{$category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <hr>
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
                                    <div class="mb-1">
                                        <label class="form-label">Difficulty</label><br>
                                        <div class="form-check form-check-inline col-xl-12 ">
                                            <input type="radio" id="beginner" name="difficulty" class="form-check-input" value="beginner" checked required>
                                            <label for="beginner" class="form-check-label">Beginner</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-12 ">
                                            <input type="radio" id="intermediate" name="difficulty" class="form-check-input" value="intermediate" required>
                                            <label for="intermediate" class="form-check-label">Intermediate</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-12 ">
                                            <input type="radio" id="expert" name="difficulty" class="form-check-input" value="expert" required>
                                            <label for="expert" class="form-check-label">Expert</label>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="container border p-3  mb-3" style="border-radius: 15px;">
                                    <div class="mb-1">
                                        <label class="form-label">Course Type</label><br>
                                        <div class="form-check col-xl-12">
                                            <input type="radio" id="paid" name="options" class="form-check-input" value="0" onclick="toggleInput(true)" checked required>
                                            <label for="paid" class="form-check-label">Paid Course</label>
                                        </div>
                                        <div class="mb-3 mt-3 input-group" id="amount">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" name="amount" class="form-control" step="0.01" placeholder="Price">
                                        </div>
                                        <div class="form-check col-xl-12">
                                            <input type="radio" id="free" name="options" class="form-check-input" value="1" onclick="toggleInput(false)">
                                            <label for="free" class="form-check-label">Free Course</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="container border p-3  mb-3" style="border-radius: 15px;">
                                    <div class="mb-1">
                                        <label for="tags" class="form-label">Tags</label>
                                        <div class="mb-3 mt-3 input-group">
                                            <span class="input-group-text">Tags</span>
                                            <input type="text" id="tag-input-field" name="tagsgenerator" class="form-control" placeholder="HTML,CSS, etc...">
                                        </div>

                                    </div>
                                    <div id="tags-container">

                                    </div>
                                </div>
                                <hr>
                                <div class="container p-0 mt-3 mb-3" style="border-radius: 15px;">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
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
<script>
    function toggleInput(show) {
        var input = document.getElementById('amount');
        if (show) {
            input.style.display = '';
        } else {
            input.style.display = 'none';
        }
    }
</script>
<script>
    document.getElementById('course-form').addEventListener('submit',
        function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.setAttribute('disabled', 'true');
            submitBtn.innerText = 'Submitting...';
            const tags = document.querySelectorAll('.tags');

            tags.forEach(tag => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'tags[]';
                hiddenInput.value = tag.textContent;
                document.getElementById('course-form').appendChild(hiddenInput);
            });

            this.submit();
        });

    document.getElementById('tag-input-field').addEventListener('keydown',
        function(e) {
            if (e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault();

                const value = this.value.trim();

                if (value) {
                    const tag = document.createElement("span");
                    tag.className = "tags";
                    tag.textContent = value;
                    const removeBtn = document.createElement("i");
                    removeBtn.className = "fa-solid fa-circle-xmark";

                    removeBtn.onclick = function() {
                        tag.remove();
                    };

                    tag.appendChild(removeBtn);

                    document.getElementById('tags-container').appendChild(tag);

                    this.value = "";
                }
            }
        });
</script>
@endsection