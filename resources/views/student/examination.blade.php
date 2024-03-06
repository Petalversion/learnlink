@extends('layout.main-side')

@section('content')

@foreach($header as $course)
<title>{{$course->title}}</title>
@endforeach


<!-- start Quiz button -->
<div class="start_btn d-flex align-items-center"><button>Start Quiz</button></div>

<!-- Info Box -->
<div class="info_box">
    <div class="info-title"><span>Rules of this Quiz</span></div>
    <div class="info-list">
        <div class="info">1. You will have only <span>60 seconds</span> per each question.</div>
        <div class="info">2. Once you select your answer, it can't be undone.</div>
        <div class="info">3. You can't select any option once time goes off.</div>
        <div class="info">4. You can't exit from the Quiz while you're playing.</div>
        <div class="info">5. You'll get points on the basis of your correct answers.</div>
    </div>
    <div class="buttons">
        <button class="quit">Exit Quiz</button>
        <button class="restart">Continue</button>
    </div>
</div>

<!-- Quiz Box -->
<div class="quiz_box">
    <header>
        <div class="title"></div>
        <div class="timer">
            <div class="time_left_txt">Time Left</div>
            <div class="timer_sec">60</div>
        </div>
        <div class="time_line"></div>
    </header>
    <section>
        <div class="que_text">
            <!-- Here I've inserted question from JavaScript -->
        </div>
        <div class="option_list">
            <!-- Here I've inserted options from JavaScript -->
        </div>
    </section>

    <!-- footer of Quiz Box -->
    <footer>
        <div class="total_que">
            <!-- Here I've inserted Question Count Number from JavaScript -->
        </div>
        <button class="next_btn">Next</button>
    </footer>
</div>

<!-- Result Box -->
<div class="result_box">

    <div class="complete_text">You've completed the Quiz!</div>
    <div class="score_text">
        <!-- Here I've inserted Score Result from JavaScript -->
    </div>
    <div class="buttons">
        <button class="restart">Retake Quiz</button>
        <button class="quit">Quit Quiz</button>
    </div>
</div>
<div id="questions-data" data-json="{{ $jsonFormattedQuestions }}"></div>
<div class="sticky-bottom text-end">
    <div class="position-fixed bottom-0 end-0 m-3">
        <button class="btn btn-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-journal-bookmark-fill me-3"></i>Lessons</button>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body text-start">
            <ul class="nav flex-column">
                <h2>{{$course->title}}</h2>
                <hr>
                @foreach($course->lessons as $lessons)

                <a href="{{ route('student.learn', ['course_id' => $course->course_id, 'lesson_id' => $lessons->lesson_id]) }}">Lesson
                    {{$loop->iteration}}:</a>

                <div class="panel">
                    <p>{{$lessons->title}}</p>
                </div>
                @endforeach

                <a href="{{ route('student.examination', ['course_id' => $course->course_id]) }}">Take the Quiz!</a>
            </ul>
        </div>
    </div>
</div>