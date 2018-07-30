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
                <table class="table">
                    <thead>
                        <td class="d-none d-md-table-cell">N.p.k.</td>
                        <td class="d-none d-sm-table-cell">Kods</td>
                        <td>Nosaukums</td>
                        <td>Aizpildījumi</td>
                        <td>KP</td>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td class="d-none d-md-table-cell">{{ $loop->iteration }}</td>
                                <td class="d-none d-sm-table-cell">{{ $course->code }}</td>
                                <td><a class="nav-link" href="{{ route('course.show', compact(['program', 'semester', 'course'])) }}">{{ $course->name }}</a></td>
                                <td>{{ $course->submissions_count }}</td>
                                <td>{{ $course->credits }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection