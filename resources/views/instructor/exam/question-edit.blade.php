@extends('layout.main-side')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">
    <a href="{{ route('instructor.course.course-view', ['course_id' => $quiz->course->id]) }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <!-- Page Heading -->



    <!-- Content Row -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('instructor.exam.update', ['exam_id' => $quiz->id]) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

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
                    <!-- Hidden input for course_id -->
                    <input type="hidden" name="exam_id" value="{{ session('exam_id') }}">
                    <!-- Begin Page Content -->
                    <div class="container mt-2">
                        <div class="table-responsive">
                            <h2 style="margin-bottom: 4%;">Edit Exam Question</h2>
                            <div class="mb-3">
                                <div>
                                    <label for="type">Type:</label>
                                    @foreach(['ToF', 'MC'] as $type)
                                    <div>
                                        <input type="radio" id="{{ $type === 'ToF' ? 'true_false_radio' :
                                                            'multiple_choice_radio' }}" name="type" value="{{ $type }}" class="radio-type" {{ old('type', $quiz->type) === $type ?
                                                        'checked' : '' }} required>
                                        <label for="{{ $type }}">{{ $type === 'ToF' ? 'True or False' :
                                                            'Multiple Choice' }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="question" class="form-label">Question:</label>
                                <input type="text" id="question" name="question" class="form-control" value="{{ old('question', $quiz->question) }}" required>
                                <hr>
                            </div>
                            <div id="multiple_choice_fields" style="display: none;">
                                <label for="answer" class="form-label">Answer:</label>
                                <input type="text" name="answer" class="form-control" value="{{ old('answer', $quiz->answer) }}">
                                <hr>
                                <label for="choice2" class="form-label">Choices:</label>
                                @if(is_array($quiz->choices))
                                @foreach($quiz->choices as $index => $choice)
                                @if($index > 0)
                                <input type="text" name="choice{{$index + 1}}" class="form-control" value="{{ $choice }}" style="margin-bottom:5px;">
                                @endif
                                @endforeach
                                @endif
                                <hr>
                            </div>
                            <div id="true_false_fields" style="display: none;">
                                <!-- Textbox for true/false -->
                                <div>
                                    <label for="answer" class="form-label">Answer:</label><br>
                                    @foreach(['True', 'False'] as $answer)
                                    <input type="radio" name="answer" value="{{ $answer }}" {{
                                                        old('answer', $quiz->answer) === $answer ?
                                                    'checked' : '' }}>
                                    <label>{{ $answer }}</label>
                                    @endforeach
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 4%;">Update</button>

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
</script>
@endsection