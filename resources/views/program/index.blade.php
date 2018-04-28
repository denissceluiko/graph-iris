@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3>Studiju programmas</h3>
                <table class="table">
                    <thead>
                        <td>Programmas kods</td>
                        <td>Programmas nosaukums</td>
                    </thead>
                    <tbody>
                    @foreach($programs as $program)
                        <tr>
                            <td>{{ $program->id }}</td>
                            <td>{{ $program->name }}</td>
                            <td><a class="btn btn-primary" href="{{ route('program.show', ['program' => $program]) }}" role="button">Skatīt</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection