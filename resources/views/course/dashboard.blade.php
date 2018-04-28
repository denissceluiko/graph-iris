@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <script>
                    var data = {!! $data !!};
                </script>
                <div class="card">
                    <div class="card-header">Kursa vērtējumi semestrī</div>

                    <div class="card-body">
                        <div id="box-plot" style="width:100%;height:500px;"></div>
                        <div id="histogram-plot" style="width:100%;height:600px;"></div>
                        <script>
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
                                title: 'Vērtējumu histogramma',
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
                </div>
                <div class="card">
                    <div class="card-header">Komentāri</div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                @foreach($comments as $comment)
                                    @if($comment == null) @continue @endif
                                    <tr><td>{{ $comment }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
