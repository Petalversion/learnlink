@extends('layout.main-side')

@section('content')
<title>{{$name}} - {{$course->title}}</title>


<div class="sidetoppadding">

    <!-- Page Heading -->

    <a href="{{ route('instructor.course.course') }}">
        <button type="button" class="btn btn-primary" style="margin-bottom: 20px;">Back</button></a>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <!-- Begin Page Content -->
                <div class="container-fluid mt-2">
                    <div class="row mx-2">
                        <div class="col-sm-8 container m-2">
                            <h1>Course Details</h1>
                            <hr>
                            <h3>{{$course->title}}</h3>
                            <p class="mt-3 fw-bold">{{$course->summary}}</p>
                            <p class="text-muted"></p>
                            <p class="mt-3 fw-bold">Difficulty:
                                <span class="badge rounded-pill {{$course->difficulty == 'beginner' ? 'badge-beginner' : ($course->difficulty == 'intermediate' ? 'badge-intermediate' : 'badge-expert')}}">
                                    {{$course->difficulty}}
                                </span>
                            </p>
                            @if ($course_count)
                            @php
                            $fullStars = floor($rounded_rating);
                            $halfStar = round($rounded_rating - $fullStars, 1) >= 0.5 ? 1 : 0;
                            $blankStars = 5 - $fullStars - $halfStar;

                            $stars = '';

                            for ($i = 0; $i < $fullStars; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } if ($halfStar) { $stars .='<i class="fa-solid fa-star-half-stroke" style="color: #ffa500;"></i>' ; } for ($i=0; $i < $blankStars; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <p><strong>{{ number_format($rounded_rating, 1) }}</strong> {!! $stars !!} ({{ $course_count }})</p>
                                @else
                                <p>No Reviews Yet</p>
                                @endif
                                <form action="{{ route('course.status.update', ['course_id' => $course->course_id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row align-items-center">
                                        <label for="status" class="form-label">Set Status</label>
                                        <div class="col-md-6">
                                            <select name="status" id="status" class="form-select" {{ $combo == 0 ? 'disabled' : '' }}>
                                                <option value="publish" {{ old('status', $course->status) === 'publish' ? 'selected' : '' }}>Publish</option>
                                                <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary" class="form-select" {{ $combo == 0 ? 'disabled' : '' }}>Update</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="badge bg-success"></p>

                        </div>
                        <div class="col-sm-3 container d-flex align-items-center">
                            @if ($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" style="max-width: 100%;">
                            @else
                            <!-- Placeholder image or any alternative content when $course->image is null -->
                            <img src="{{ asset('img/course_placeholder.png') }}" alt="Placeholder Image" style="max-width: 100%;">
                            @endif

                        </div>
                    </div>
                </div>


                </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif


                <div class="container-fluid mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2><i class="fa-solid fa-chalkboard"></i> Lessons</h2>
                        <a href="{{ route('instructor.lesson.lesson-create', ['course_id' => $course->id]) }}" class="btn btn-primary btn-icon-split p-0"><span class="icon text-white-50"><i class="fas fa-plus"></i></span><span class="text">Lessons</span></a>
                    </div>
                    <div class="mt-4">
                        @if(count($course->lessons) < 5) <p>You need to have atleast <strong>5 Lessons</strong> to Publish your Course!</p>
                            <p>You need <strong>{{5-(count($course->lessons))}}</strong> more to publish your Course! Keep Going!</p>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable12345">
                                    <thead>
                                        <tr>
                                            <th class="text-right">No.</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Questions</th>
                                            <th class="text-center">Attachments</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($course->lessons as $lesson)
                                        <tr>
                                            <td class="text-right">{{ $loop->iteration }}.</td>
                                            <td> {{$lesson->title}} </td>
                                            <td class="text-center"> <a href="{{ route('instructor.course.questions', ['lesson_id' => $lesson->id])}}" class="btn btn-success">
                                                    <i class="fa-solid fa-comments text-white"></i>
                                                </a> </td>
                                            <td class="text-left">
                                                @if (!empty($lesson->uploadedFiles))
                                                @foreach ($lesson->uploadedFiles as $file)
                                                @if (is_array($file) && isset($file['name']))
                                                {{ htmlspecialchars($file['name']) }}<br>
                                                @endif
                                                @endforeach
                                                @else
                                                No files uploaded
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                <!-- Edit Link -->
                                                <a href="{{ route('instructor.lesson.lesson-edit', ['lesson_id' => $lesson->id]) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit fa-sm"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteLessonModal{{$lesson->id}} ">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteLessonModal{{$lesson->id}}" tabindex="-1" aria-labelledby="deleteLessonModal{{$lesson->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action=" {{route('instructor.lesson.lesson-destroy', ['lesson_id' => $lesson->id])}}" method="POST" id="lessonDeleteForm{{$lesson->id}}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteQuizLabel{{$lesson->id}}">Delete Lesson</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this Lesson
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger" onclick="deleteLesson({{$lesson->id}})" id="deleteLesson_{{$lesson->id}}">Delete</button>
                                                        </div>
                                                    </form>
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
        </div>
    </div>

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">



                <div class="container-fluid mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2><i class="fa-solid fa-chalkboard-user"></i> Questions</h2>
                        <a href="{{ route('instructor.exam.question-create', ['course_id' => $course->id]) }}" class="
                                            btn btn-primary btn-icon-split p-0"><span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span><span class="text">Questions</span></a>
                    </div>
                    <div class="mt-4">
                        @if(count($course->quiz) < 25) <p>You need to have at least <strong>25 Questions</strong> to Publish your Course!</p>
                            <p>You need <strong>{{25-(count($course->quiz))}}</strong> more to publish your Course! Keep Going!</p>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable123456">
                                    <thead>
                                        <tr>
                                            <th class="text-right">No.</th>
                                            <th class="text-center">Question</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Answer</th>
                                            <th class="text-center">Choices</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($course->quiz as $question)
                                        <tr>
                                            <td class="text-right">{{ $loop->iteration }}.</td>
                                            <td> {{$question->question}} </td>
                                            <td> {{$question->type}} </td>
                                            <td> {{$question->answer}} </td>
                                            <td>
                                                @foreach ($question->choices as $choice)
                                                {{ $choice }}<br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <!-- Edit Link -->
                                                <a href="{{ route('instructor.exam.question-edit', ['exam_id' => $question->id]) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit fa-sm"></i>
                                                </a>
                                                <!-- View Link -->

                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQuizModal{{$question->id}}">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteQuizModal{{$question->id}}" tabindex="-1" aria-labelledby="deleteQuizModalLabel{{$question->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action=" {{route('instructor.exam.question-destroy', ['exam_id' => $question->id])}}" method="POST" id="questionDeleteForm{{$question->id}}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteQuizLabel{{$question->id}}">
                                                                Delete Question</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this Question
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger" onclick="deleteQuestion({{$question->id}})" id="deleteQuestion_{{$question->id}}">Delete</button>
                                                        </div>
                                                    </form>
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
        </div>
    </div>
</div>

<script>
    function deleteLesson(lessonId) {
        var deleteBtn = document.getElementById('deleteLesson_' + lessonId);
        deleteBtn.setAttribute('disabled', 'true');
        deleteBtn.innerText = 'Deleting...';
        document.getElementById('lessonDeleteForm' + lessonId).submit();
    }

    function deleteQuestion(questionId) {
        var deleteBtn = document.getElementById('deleteQuestion_' + questionId);
        deleteBtn.setAttribute('disabled', 'true');
        deleteBtn.innerText = 'Deleting...';
        document.getElementById('questionDeleteForm' + questionId).submit();
    }
</script>
@endsection