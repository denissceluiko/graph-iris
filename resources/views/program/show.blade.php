@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('program.index') }}">Programmas</a></li>
                <li class="breadcrumb-item"><a href="{{ route('program.show', compact('program')) }}">{{ $program->name }}</a></li>
                </ol>
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-5">Studiju programma</dt>
                    <dd class="col-sm-7">{{ $program->name }}</dd>
                    <dt class="col-sm-5">Programmas kods</dt>
                    <dd class="col-sm-7">{{ $program->id }}</dd>
                </dl>
                <a class="btn btn-primary" href="{{ route('program.edit', $program) }}">Rediģēt</a>
            </div>
            <div class="col-md-6">
                <dl>
                    <dt>Semesteris</dt>
                    <dd>
                        <ol class="nav nav-pills">
                            @foreach($semesters as $sem)
                                <li class="nav-item">
                                    <a class="nav-link{{ $semester->code == $sem->code ? ' active' : '' }}"
                                       href="{{ route('program.show', compact(['program', 'sem'])) }}">
                                        {{ $sem->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>Kursi</h3>
                <ul class="nav nav-pills mb-3" id="course-list-view">
                    <li class="nav-item">
                        <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary">Apkopojums</a>
                    </li>
                </ul>
                <div class="tab-content" id="course-list-viewContent">
                    <div class="tab-pane fade show active" id="summary">
                        <table class="table">
                            <thead class="sticky-header">
                                <tr>
                                    <th class="d-none d-sm-table-cell">Kods</th>
                                    <th>Nosaukums</th>
                                    <th>Aizpildījumi</th>
                                    <th title="{{ $questions['course_description'] }}">Q</th>
                                    <th title="{{ $questions['course_duplication'] }}">Q</th>
                                    <th title="{{ $questions['lecturer_understandable'] }}">Q</th>
                                    <th title="{{ $questions['lecturer_methods'] }}">Q</th>
                                    <th title="{{ $questions['literature_usefullness'] }}">Q</th>
                                    <th title="{{ $questions['estudies_materials'] }}">Q</th>
                                    <th title="{{ $questions['course_tests'] }}">Q</th>
                                    <th title="{{ $questions['lecturer_consultations'] }}">Q</th>
                                    <th title="{{ $questions['course_results'] }}">Q</th>
                                    <th title="{{ $questions['lecturer_again'] }}">Q</th>
                                    <th title="{{ $questions['test_explanation'] }}">Q</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="d-none d-sm-table-cell">{{ $course->code }}</td>
                                    <td><a class="" href="{{ route('course.show', compact(['program', 'semester', 'course'])) }}">{{ $course->name }}</a> ({{ $course->credits }} KP)</td>
                                    <td>{{ $course->submissions->count() }}</td>
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('course_description'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('course_duplication'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('lecturer_understandable'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('lecturer_methods'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('literature_usefullness'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('estudies_materials'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('course_tests'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('lecturer_consultations'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('course_results'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('lecturer_again'), 'threshold' => 4])@endcomponent
                                    @component('components.average-score-cell', ['value' => $course->submissions->average('test_explanation'), 'threshold' => 4])@endcomponent
                                    {{--<td>{{ round($course->submissions->average('course_time'), 2) }}</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection