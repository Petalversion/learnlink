@extends('layout.main-side')

@section('content')
<title>{{$name}} - Recent Questions</title>

<div class="sidetoppadding">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <!-- Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-body">
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
                        <h2 style="margin-bottom: 2%;"><i class="fas fa-history"></i> Recent Questions</h2>
                        @foreach($all_student_comments as $comment)
                        @php
                        $lesson = $comment->lesson ?? null;
                        @endphp

                        @if($lesson)
                        <tr class="text-center">
                            <td>{{ $lesson->course->title ?? 'N/A' }}</td>
                            <td>{{ $lesson->title ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}">
                                    <i class="fas fa-eye fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                        @endif

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        @if($comment->student_info && $comment->student_info->profile_picture)
                                        <img class="profile-picture" src="{{ asset('storage/' . $comment->student_info->profile_picture) }}" alt="" width="10%">
                                        @endif
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>{{ $comment->student->name ?? 'N/A' }}</h5>
                                        <p>Date: {{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') }}</p>
                                        <p>{{ $comment->comment }}</p>
                                        @foreach($comment->answers as $answer)
                                        <div class="card mb-3" style="background-color:#e2e2e2">
                                            <div class="card-body">
                                                <p class="small text-bold">You replied:</p>
                                                <p class="small">{{ $answer->comment }}</p>
                                            </div>
                                        </div>
                                        @endforeach

                                        <form action="{{ route('add.answer') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $comment->comment_id }}" name="comment_id">
                                            <input type="hidden" value="{{ $instructor_info->instructor_id }}" name="instructor_id">
                                            <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="Message..."></textarea>

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