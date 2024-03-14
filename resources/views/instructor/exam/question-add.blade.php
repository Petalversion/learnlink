@extends('layout.main-side')

@section('content')<!-- Begin Page Content -->
<title>{{$name}} - New Question</title>
<div class="sidetoppadding">
    <a href="{{ route('instructor.course.course-view', ['course_id' => $courses->id]) }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('instructor.exam.question-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $courses->course_id }}">
                    <div class="container mt-2">
                        <div class="table-responsive">
                            <h2 style="margin-bottom: 4%;">Add Exam Question</h2>
                            <div class="mb-3">
                                <div>
                                    <label for="type">Type:</label>
                                    <div>
                                        <label><input type="radio" name="type" value="ToF" id="true_false_radio"> True or
                                            False</label><br>
                                        <label><input type="radio" name="type" value="MC" id="multiple_choice_radio"> Multiple
                                            Choice</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="question" class="form-label">Question:</label>
                                <input type="text" id="question" name="question" class="form-control" required>
                                <hr>
                            </div>
                            <div id="multiple_choice_fields" style="display: none;">
                                <label for="answer" class="form-label">Answer:</label>
                                <input type="text" name="answer" class="form-control">
                                <hr>
                                <label for="choice2" class="form-label">Choices:</label>
                                <input type="text" name="choice2" class="form-control" style="margin-bottom:5px;">
                                <input type="text" name="choice3" class="form-control" style="margin-bottom:5px;">
                                <input type="text" name="choice4" class="form-control">
                                <hr>
                            </div>
                            <div id="true_false_fields" style="display: none;">
                                <!-- Textbox for true/false -->
                                <div>
                                    <label for="answer" class="form-label">Answer:</label><br>
                                    <label><input type="radio" name="answer" value="True">
                                        True</label><br>
                                    <label><input type="radio" name="answer" value="False">
                                        False</label>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 4%;" id="submitBtn">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Function to show/hide textboxes based on radio button selection
    function toggleFields() {
        if (document.getElementById('multiple_choice_radio').checked) {
            document.getElementById('multiple_choice_fields').style.display = 'block';
            document.getElementById('true_false_fields').style.display = 'none';
        } else if (document.getElementById('true_false_radio').checked) {
            document.getElementById('multiple_choice_fields').style.display = 'none';
            document.getElementById('true_false_fields').style.display = 'block';
        } else {
            document.getElementById('multiple_choice_fields').style.display = 'none';
            document.getElementById('true_false_fields').style.display = 'none';
        }
    }

    // Call toggleFields function initially to set the initial state
    toggleFields();

    // Add event listener to radio buttons to call toggleFields function when stion cha 
    document.getElementById('multiple_choice_radio').addEventListener('change', toggleFields);
    document.getElementById('true_false_radio').addEventListener('change', toggleFields);

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('submitBtn').addEventListener('click', function() {
            this.setAttribute('disabled', 'true');
            this.innerText = 'Submitting...';
            document.querySelector('form').submit();
        });
    });
</script>
@endsection