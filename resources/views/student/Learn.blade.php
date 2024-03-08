@extends('layout.main-side')

@section('content')

<title>{{$lesson->title}}</title>
<div class="sidetoppadding">
  <div class="container-fluid">
    <h1>{{$lesson->title}}</h1>
    <hr>
    @if(!is_null($lesson) && !is_null($lesson->video_source))
    <div class="card shadow mb-4">
      <div class="card-body">
        <iframe src="{{ asset('storage/' . $lesson->video_source) }}" width="100%" height="480" allow="autoplay"></iframe>
      </div>
    </div>
    @endif
    @if(!is_null($lesson) && !is_null($lesson->content))
    <div class="card shadow mb-4">
      <div id="editor" class="card shadow p-4">
        {!!$lesson->content!!}
      </div>
    </div>
    @endif
  </div>

  <ul class=" nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment-tab-pane" type="button" role="tab" aria-controls="comment-tab-pane" aria-selected="true">Comment</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating-tab-pane" type="button" role="tab" aria-controls="rating-tab-pane" aria-selected="false">Ratings</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="comment-tab-pane" role="tabpanel" aria-labelledby="comment-tab" tabindex="0">
      <div class="container-fluid">
        <div class="row">
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <div class="col-md-12 ">
            <form action="{{ route('add.question') }}" method="POST">
              @csrf
              <div class="form-group">
                <br>
                <label for="comment">Comment:</label>
                <input type="hidden" value="{{$course->course_id}}" name="course_id">
                <input type="hidden" value="{{$lesson->lesson_id}}" name="lesson_id">
                <input type="hidden" value="{{$user->student_id}}" name="student_id">
                <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
                <br>
              </div>
              <button class="btn btn-info" type="submit">Submit</button>
            </form>
          </div>
        </div>
        @foreach($student_comment as $comments)
        <div class="row d-flex justify-content-center border mb-2 mt-5">
          <div class="col-md-2 d-flex align-items-center justify-content-center">
            <img class="d-flex fixed-profile-image" src="{{ asset('storage/' . $comments->student_info->profile_picture) }}" alt="Image Description">
          </div>
          <div class="col-md-10 d-flex">
            <div class="media-comment-wrapper">
              <div class="media g-mb-30 media-comment">
                <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                  <div class="g-mb-15">
                    <h5 class="h5 g-color-gray-dark-v1 mb-0 mt-3">{{$comments->student->name}}</h5>
                    <span class="g-color-gray-dark-v4 g-font-size-12">{{$comments->created_at->diffForHumans()}}</span>
                    <hr>
                  </div>
                  <p>{{$comments->comment}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        @if($comments->answer->isNotEmpty())
        @foreach($comments->answer as $answer)
        <div class="row d-flex justify-content-center border mb-2 ml-5">
          <div class="col-md-2 d-flex align-items-center justify-content-center">
            <img class="d-flex fixed-profile-image" src="{{ asset('storage/' . $answer->instructor_info->profile_picture) }}" alt="Image Description">
          </div>
          <div class="col-md-10">
            <div class="media-comment-wrapper">
              <div class="media g-mb-30 media-comment">
                <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                  <div class="g-mb-15">
                    <h5 class="h5 g-color-gray-dark-v1 mb-0 mt-3">{{$answer->instructor->name}} - Instructor</h5>
                    <span class="g-color-gray-dark-v4 g-font-size-12">{{$answer->created_at->diffForHumans()}}</span>
                    <hr>
                  </div>
                  <p>{{$answer->comment}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        @endif
        @endforeach
      </div>
    </div>



    <div class="tab-pane fade" id="rating-tab-pane" role="tabpanel" aria-labelledby="rating-tab" tabindex="0">
      <div class="container">
        <div class="row">
          <div class="col-10 mx-auto mb-5">
            @if(empty($student_review))
            <form action="{{ route('add.review') }}" method="POST">
              @csrf
              <div class="form-group mt-4">
                <label for="comment">Review:</label>
                <input type="hidden" value="{{$course->course_id}}" name="course_id">
                <input type="hidden" value="{{$user->student_id}}" name="student_id">
                <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
                <br>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-info" type="submit">Submit</button>
                </div>
                <div class="col-md-6 text-right">
                  <div class="rate">
                    <input type="radio" id="star5" name="score" value="5" />
                    <label for="star5" title="5 stars">5 stars</label>
                    <input type="radio" id="star4" name="score" value="4" />
                    <label for="star4" title="4 stars">4 stars</label>
                    <input type="radio" id="star3" name="score" value="3" />
                    <label for="star3" title="3 stars">3 stars</label>
                    <input type="radio" id="star2" name="score" value="2" />
                    <label for="star2" title="2 stars">2 stars</label>
                    <input type="radio" id="star1" name="score" value="1" />
                    <label for="star1" title="1 star">1 star</label>
                  </div>
                </div>
              </div>
            </form>
            @else
            <div class="row d-flex justify-content-center border mb-2 mt-5">
              <div class="col-md-2 d-flex align-items-center justify-content-center">
                <img class="d-flex fixed-profile-image" src="{{ asset('storage/' . $student_review->student_info->profile_picture) }}" alt="Image Description">
              </div>
              <div class="col-md-10 d-flex">
                <div class="media-comment-wrapper">
                  <div class="media g-mb-30 media-comment">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                      <div class="g-mb-15">
                        <h5 class="h5 g-color-gray-dark-v1 mb-0 mt-3">{{$student_review->student->name}}</h5>
                        <span class="g-color-gray-dark-v4 g-font-size-12">{{$student_review->created_at->diffForHumans()}}</span>
                        @php
                        $stars = '';
                        for ($i = 0; $i < $student_review->score; $i++) {
                          $stars .= '<i class="fa-solid fa-star" style="color: #ffa500;"></i>';
                          }
                          for ($i = $student_review->score; $i < 5; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <h5 class="h5 text-warning mb-0 mt-1">{!! $stars !!}</h5>
                            <hr style="width: 200px;">
                      </div>
                      <p class=" mb-3 mt-0">{{$student_review->comment}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @foreach($course_reviews as $reviews)
            <div class="row d-flex justify-content-center border mb-2 mt-5">
              <div class="col-md-2 d-flex align-items-center justify-content-center">
                <img class="d-flex fixed-profile-image" src="{{ asset('storage/' . $reviews->student_info->profile_picture) }}" alt="Image Description">
              </div>
              <div class="col-md-10 d-flex">
                <div class="media-comment-wrapper">
                  <div class="media g-mb-30 media-comment">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                      <div class="g-mb-15">
                        <h5 class="h5 g-color-gray-dark-v1 mb-0 mt-3">{{$reviews->student->name}}</h5>
                        <span class="g-color-gray-dark-v4 g-font-size-12">{{$reviews->created_at->diffForHumans()}}</span>

                        @php
                        $stars = '';
                        for ($i = 0; $i < $reviews->score; $i++) {
                          $stars .= '<i class="fa-solid fa-star" style="color: #ffa500;"></i>';
                          }
                          for ($i = $reviews->score; $i < 5; $i++) { $stars .='<i class="fa-regular fa-star" style="color: #ffa500;"></i>' ; } @endphp <h5 class="h5 text-warning mb-0 mt-1">{!! $stars !!}</h5>
                            <hr style="width: 200px;">
                      </div>
                      <p class=" mb-3 mt-0">{{$reviews->comment}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Sticky button -->
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
</div>
@endsection