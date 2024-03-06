@extends('layout.main-side')

@section('content')
<div class="container-fluid" style="padding-left: 250px; margin-top:5%;">

    <!-- Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Begin Page Content -->
            <div class="container-fluid mt-2" style="max-width: 100%; overflow-x: auto;">
                <table class="table table-striped" id="myTable12345">
                    <thead>
                        <tr class="text-center">
                            <th>Course</th>
                            <th>Lesson</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <h2 style="margin-bottom: 2%;">Recent Questions</h2>
                        @foreach($all_student_comments as $comment)
                        <tr class="text-center">
                            @php
                            $lesson = \App\Models\Lesson::where('lesson_id', $comment['lesson_id'])->first();
                            @endphp
                            @if($lesson)
                            <td>
                                {{ $lesson->course->title }}
                            </td>
                            <td>{{ $lesson->title }}</td>
                            @endif
                            <td>{{ \Carbon\Carbon::parse($comment['created_at'])->format('Y-m-d H:i') }}</td>

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
                                        <p>{{ $comment['comment'] }}</p>
                                        @php
                                        $comments = \App\Models\Answers::where('comment_id', $comment['comment_id'])->where('instructor_id', $user->instructor_id)->get();
                                        @endphp
                                        @if($comments)
                                        @foreach($comments as $comment)
                                        <div class="card mb-3" style="background-color:#e2e2e2">
                                            <div class="card-body">
                                                <p class="small text-bold">You replied:</p>
                                                <p class="small">{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                        <form action="{{ route('add.answer') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$comment['comment_id']}}" name="comment_id">
                                            <input type="hidden" value="{{$instructor_info->instructor_id}}" name="instructor_id">
                                            <textarea class="form-control" name="comment" id="" cols="30" rows="5" placeholder="Message..."></textarea>

                                            <div class="text-right mt-3">
                                                <button type="submit" name="submit" class="btn btn-primary">Send Reply</button>
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
@endsection