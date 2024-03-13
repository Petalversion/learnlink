@extends('layout.main-side')

@section('content')
<title>{{$name}} - Course Reviews</title>
<div class="sidetoppadding">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped " id="myTable12345">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">Date</th>
                            <th>Course</th>
                            <th class="text-center">Rating</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h2 style="margin-bottom: 2%;"><i class="fa-solid fa-ranking-star"></i> Course Reviews</h2>
                        @foreach($all_student_reviews as $comment)
                        <tr class="text-center">
                            <td class="text-center">{{ \Carbon\Carbon::parse($comment['created_at'])->format('Y-m-d') }}</td>
                            @php
                            $lesson = \App\Models\Course::where('course_id', $comment['course_id'])->first();
                            @endphp
                            @if($lesson)
                            <td>
                                {{ $lesson->title }}
                            </td>
                            @endif
                            <td class="text-center" data-order="{{ $comment['score'] }}">
                                @php
                                $stars = '';
                                for ($i = 0; $i < $comment['score']; $i++) { $stars .='<i class="fa-solid fa-star" style="color: #ffa500;"></i>' ; } for ($i=$comment['score']; $i < 5; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <h5 class="h5 text-warning mb-0 mt-1">{!! $stars !!}</h5>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fas fa-eye fa-sm"></i></a>
                            </td>
                        </tr>
                        <!-- question modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        @php
                                        $img = \App\Models\Student_info::where('student_id', $comment['student_id'])->first();
                                        @endphp
                                        @if($img)
                                        <img class="profile-picture" src="{{ asset('storage/' . $img->profile_picture) }}" alt="" width="10%">
                                        @endif
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>
                                            @php
                                            $course = \App\Models\Student::where('student_id', $comment['student_id'])->first();
                                            @endphp
                                            @if($course)
                                            {{ $course->name }}
                                            @endif
                                        </h5>
                                        <p>Date: {{ \Carbon\Carbon::parse($comment['created_at'])->format('Y-m-d H:i') }}</p>
                                        <div class="card mb-3" style="background-color:#e2e2e2">
                                            <div class="card-body">
                                                <p class="small">{{ $comment['comment'] }}</p>
                                            </div>
                                        </div>
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