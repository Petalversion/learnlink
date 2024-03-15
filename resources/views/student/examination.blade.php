@extends('layout.main-side')

@section('content')

@foreach($header as $course)
<title>{{$course->title}}</title>
@endforeach
<div class="sidetoppadding">
    @if(($attempt>=3) && ($remainingTime != ""))
    <div class="col-xl-12 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 px-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">You have {{$remainingTime}} before you can retake the Quiz again!</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- start Quiz button -->
    <div class="start_btn text-center"><button>Start Quiz</button></div>

    <!-- Info Box -->
    <div class="info_box" style="z-index: 1001">
        <div class="info-title"><span>Rules of this Quiz</span></div>
        <div class="info-list">
            <div class="info">1. You will have only <span>60 seconds</span> per each question.</div>
            <div class="info">2. Once you select your answer, it can't be undone.</div>
            <div class="info">3. You can't select any option once time goes off.</div>
            <div class="info">4. You'll get points on the basis of your correct answers.</div>
            <div class="info">5. Requirement to pass: <span>75%</span>.</div>
            <div class="info">6. If you fail <span>3</span> times in a row you won't be able to retake the quiz for<span> 24hrs</span>.</div>
        </div>
        <div class="buttons">
            <button class="quit">Exit Quiz</button>
            <button class="restart">Continue</button>
        </div>
    </div>

    <!-- Quiz Box -->
    <div class="quiz_box" style="z-index: 1001">
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
    <div class="result_box" style="z-index: 1001">

        <div class="complete_text">You've completed the Quiz!</div>
        <div class="score_text">
            <!-- Here I've inserted Score Result from JavaScript -->
        </div>
        <div class="buttons">
            <button class="restart" hidden>Retake Quiz</button>
            <button class="quit">Quit Quiz</button>
        </div>
    </div>
    <div id="questions-data" data-json="{{ $jsonFormattedQuestions }}"></div>
    @endif
    <div class="sticky-bottom text-end">
        <div class="position-fixed bottom-0 end-0 m-3">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-journal-bookmark-fill me-3"></i>Lessons</button>
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

                    <a class="btn btn-secondary text-start" href="{{ route('student.learn', ['course_id' => $course->course_id, 'lesson_id' => $lessons->lesson_id]) }}"><i class="fa-solid fa-book"></i> Lesson
                        {{$loop->iteration}}:</a>

                    <div class="panel mt-2 ml-1">
                        <p>{{$lessons->title}}</p>
                    </div>
                    @endforeach

                    <a class="btn btn-success text-start" href="{{ route('student.examination', ['course_id' => $course->course_id]) }}"><i class="fa-solid fa-pencil"></i> Take the Quiz!</a>
                </ul>
            </div>
        </div>
        <input type="hidden" name="courseIdInput" id="courseIdInput" value="{{$coursex}}">
    </div>

</div>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const courseId = courseIdInput ? courseIdInput.value : null;
    // Define the saveScoreToDatabase function
    function saveScoreToDatabase(percentage) {
        // Send a POST request with the CSRF token included in the headers
        fetch('/save-score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    percentage: percentage,
                    course_id: courseId
                }),
            })
            .then(response => {
                // Handle response
                console.log('Score saved successfully');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
@endsection