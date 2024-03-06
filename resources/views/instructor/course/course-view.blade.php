@extends('layout.main-side')

@section('content')
<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">

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
                        <div class="col-sm-8 container m-2" style="border-radius: 20px;">
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

                            <p class="badge bg-success"></p>
                        </div>
                        <div class="col-sm-3 container d-flex align-items-center">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" style="max-width: 100%;">
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
                        <h2>Lessons</h2>
                        <a href="{{ route('instructor.lesson.lesson-create', ['course_id' => $course->course_id]) }}" class="btn btn-primary btn-icon-split p-0"><span class="icon text-white-50"><i class="fas fa-plus"></i></span><span class="text">Lessons</span></a>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-right">No.</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Attachments</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->lessons as $lesson)
                                    <tr>
                                        <td class="text-right">{{ $loop->iteration }}.</td>
                                        <td> {{$lesson->title}} </td>
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
                                            <a href="{{ route('instructor.lesson.lesson-edit', ['lesson_id' => $lesson->lesson_id]) }}" class="btn btn-primary">
                                                <i class="fas fa-edit fa-sm"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteLessonModal{{$lesson->lesson_id}} ">
                                                <i class="fas fa-trash fa-sm"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="deleteLessonModal{{$lesson->lesson_id}}" tabindex="-1" aria-labelledby="deleteLessonModal{{$lesson->lesson_id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action=" {{route('instructor.lesson.lesson-destroy', ['lesson_id' => $lesson->lesson_id])}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteQuizLabel{{$lesson->lesson_id}}">Delete Lesson</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this Lesson
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
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
                        <h2>Exam Questions</h2>
                        <a href="{{ route('instructor.exam.question-create', ['course_id' => $course->course_id]) }}" class="
                                            btn btn-primary btn-icon-split p-0"><span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span><span class="text">Questions</span></a>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                            <a href="{{ route('instructor.exam.question-edit', ['exam_id' => $question->exam_id]) }}" class="btn btn-primary">
                                                <i class="fas fa-edit fa-sm"></i>
                                            </a>
                                            <!-- View Link -->

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQuizModal{{$question->exam_id}}">
                                                <i class="fas fa-trash fa-sm"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="deleteQuizModal{{$question->exam_id}}" tabindex="-1" aria-labelledby="deleteQuizModalLabel{{$question->exam_id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action=" {{route('instructor.exam.question-destroy', ['exam_id' => $question->exam_id])}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteQuizLabel{{$question->exam_id}}">
                                                            Delete Question</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this Question
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
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
@endsection