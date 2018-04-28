@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3>{{ $program->name }} ({{ $program->id }})</h3>

                <table class="table">
                    <thead>
                        <td>Kursa kods</td>
                        <td>Kursa nosaukums</td>
                        <td>Kredītpunkti</td>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->credits }}</td>
                                <td><a class="btn btn-primary" href="{{ route('course.show', ['program' => $program, 'course' => $course]) }}" role="button">Skatīt</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection