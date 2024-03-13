@extends('layout.main-side')

@section('content')
<div class="sidetoppadding">
    <title>{{$course->title}}</title>


    <!-- Page Heading -->

    <a href="{{ route('admin.course', ['instructor_id' => $instructor->id]) }}">
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
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <div class="container-fluid mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2><i class="fa-solid fa-chalkboard"></i> Lessons</h2>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable12345">
                                <thead>
                                    <tr>
                                        <th class="text-right">No.</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Attachments</th>
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
                                    </tr>
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
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable123456">
                                <thead>
                                    <tr>
                                        <th class="text-right">No.</th>
                                        <th class="text-center">Question</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Answer</th>
                                        <th class="text-center">Choices</th>
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
                                    </tr>
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