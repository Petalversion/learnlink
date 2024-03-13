@extends('layout.main-side')

@section('content')
<title>{{$name}} - My Certificates</title>

<div class="sidetoppadding">
    <h1 class="h3 mb-3 text-gray-800"><i class="fas fa-fw fa-award"></i> Certificates</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable12345" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Course</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $certificate)
                        <tr>
                            @php
                            $course_name = \App\Models\Course::where('course_id', $certificate->course_id)->first();
                            @endphp
                            <td>{{$course_name->title}}</td>
                            <td class="text-center {{ $certificate->score > 74 ? 'text-primary' : 'text-danger' }}">
                                {{ number_format($certificate->score, 2) }}
                            </td>
                            @php
                            $cert = \App\Models\Certificate::where('student_id', $certificate->student_id)->where('course_id', $certificate->course_id)->first();
                            $certi = \App\Models\Course::where('course_id', $certificate->course_id)->where('free', 0)->first();
                            @endphp
                            @if($cert)
                            @if($certi)
                            <td class="text-center">
                                <button type="button" onclick="window.open('{{ route('certificate', ['course_id' => $certificate->course_id]) }}', '_blank')" class="badge badge-pill badge-success"><i class="fa-solid fa-award"></i></button>
                            </td>
                            @else
                            <td></td>
                            @endif
                            @else
                            <td></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection