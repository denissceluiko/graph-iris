@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('program.show', ['program' => $program]) }}">{{ $program->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('course.show', ['program' => $program, 'course' => $course->id]) }}">{{ $course->code }} {{ $course->name }}</a></li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12 col-md-6">
                <table class="table">
                    <tr>
                        <td><b>Nosaukums</b></td>
                        <td>{{ $course->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Kods</b></td>
                        <td>{{ $course->code }}</td>
                    </tr>
                    <tr>
                        <td><b>Kredītpunkti</b></td>
                        <td>{{ $course->credits }}</td>
                    </tr>
                    <tr>
                        <td><b>Semestris</b></td>
                        <td>{{ $coursemeta['semester']->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Pasniedzēji</b></td>
                        <td>
                            @foreach($submissions->unique('lector_id') as $submission)
                                {{ $submission->position }} {{ $submission->lector->name }}<br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td><b>Aizpildījumi</b></td>
                        <td>{{ $submissions->count() }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-12 col-md-6">
                <ol class="nav flex-column nav-pills nav-fill">
                    @foreach($coursemeta['parts'] as $key => $value)
                        <li class="nav-item"><a class="nav-link{{ $key == $coursemeta['part'] ? ' active' : '' }}" href="{{ route('course.show', ['program' => $program, 'course' => $course, 'part' => $key]) }}">{{ $value }}</a></li>
                    @endforeach
                </ol>
                <div class="form-group">
                    <label>Pasniedzējs</label>
                    <select class="form-control">
                        <option>Visi</option>
                        <option value="1">Viens</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="histogram-plot" style="width:100%;height:600px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="box-plot" style="width:100%;height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Studentu komentāri</div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                @foreach($submissions->pluck('comments') as $comment)
                                    @if($comment == null) @continue @endif
                                    <tr><td>{{ $comment }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var data = {!! $data !!};

            var traces = [];

            for (trace in data)
            {
                traces.push({
                    y: data[trace],
                    type: 'box',
                    boxmean: null,
                    name: trace
                });
            }

            var layout = {
                title: 'Kursa vērtējumu vērtībamplitūdas diagramma',
                showlegend: false,
                xaxis: {
                    title: 'Kritērijs',
                    showticklabels: true,
                    tickangle: 10,
                },
                yaxis: {
                    title: 'Vērtējums',
                }
            };

            Plotly.newPlot('box-plot', traces, layout);

            traces = [];

            for (trace in data)
            {
                var x = [0, 1, 2, 3, 4, 5, 6, 7];
                var y = [0, 0, 0, 0, 0, 0, 0, 0];

                for(score in data[trace]) {
                    if (typeof data[trace][score] === 'number')
                        y[data[trace][score]]++;
                    else
                        y[0]++;
                }

                traces.push({
                    x: x,
                    y: y,
                    type: 'markers+lines',
                    name: trace,
                });
            }

            layout = {
                title: 'Vērtējumi par katru jautājumu',
                showlegend: true,
                legend: {
                    orientation: 'h',
                },
                xaxis: {
                    title: 'Vērtējums',
                },
                yaxis: {
                    title: 'Skaits',
                }
            };

            Plotly.newPlot('histogram-plot', traces, layout);
        </script>
    </div>
@endsection
