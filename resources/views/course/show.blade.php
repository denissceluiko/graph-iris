@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('program.index') }}">Programmas</a></li>
                <li class="breadcrumb-item"><a href="{{ route('program.show', compact('program', 'semester')) }}">{{ $program->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('course.show', compact('program', 'semester', 'course')) }}">{{ $course->code }} {{ $course->name }}</a></li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12 col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">Nosaukums</dt>
                    <dd class="col-sm-9">{{ $course->name }}</dd>
                    <dt class="col-sm-3">Kods</dt>
                    <dd class="col-sm-9">{{ $course->code }}</dd>
                    <dt class="col-sm-3">Kredītpunkti</dt>
                    <dd class="col-sm-9">{{ $course->credits }}</dd>
                    <dt class="col-sm-3">Semestris</dt>
                    <dd class="col-sm-9">{{ $coursemeta['semester']->name }}</dd>
                    <dt class="col-sm-3">Aizpildījumi</dt>
                    <dd class="col-sm-9">{{ $submissions->count() }}</dd>
                    <dt class="col-sm-3">Komentāri</dt>
                    <dd class="col-sm-9">{{ $submissions->filter->hasComments()->count() }}</dd>
                </dl>
            </div>
            <div class="col-12 col-md-6">
                <dl>
                    <dt>Kursa daļa</dt>
                    <dd>
                        <ol class="nav nav-pills">
                            @foreach($coursemeta['parts'] as $part => $caption)
                                <li class="nav-item">
                                    <a class="nav-link{{ $part == $coursemeta['part'] ? ' active' : '' }}"
                                       href="{{ route('course.show', compact(['program', 'semester', 'course', 'part'])) }}">
                                        {{ $caption }}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </dd>
                    <dt>Pasniedzējs</dt>
                    <dd>
                        <ol class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link{{ $filters->get('lector') == null ? ' active' : '' }}" href="{{ route('course.show', array_merge(compact(['program', 'semester', 'course']), $filters->except('lector'))) }}">Visi</a></li>
                            @foreach($submissions->unique('lector_id') as $submission)
                                <li class="nav-item">
                                    <a class="nav-link{{ $submission->lector->id == $filters->get('lector') ? ' active' : '' }}"
                                       href="{{ route('course.show', array_merge(compact('program', 'semester', 'course'), $filters->except('lector'), ['lector' => $submission->lector->id])) }}">
                                        {{ $submission->lector->name }}
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
                <div class="card my-1">
                    <div class="card-body">
                        <div id="histogram-plot" style="width:100%;height:600px;"></div>
                        <hr>
                        <p>* 0 - Nezinu, nevaru pateikt. Pārējie vērtējumi atbilst intervālam no "Pilnīgi nepiekrītu" (1) līdz "Pilnīgi piekrītu" (7)</p>
                    </div>
                </div>
            </div>
            <div class="col-12 my-1">
                <div class="card">
                    <div class="card-body">
                        <div id="box-plot" style="width:100%;height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="my-1">Komentāri</h3>
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
                title: 'Vērtējumi par katru jautājumu*',
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
