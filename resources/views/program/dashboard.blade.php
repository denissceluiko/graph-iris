@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Test chart</div>

                    <div class="card-body">
                        <div id="tester" style="width:100%;height:500px;"></div>
                        <script>
                            var layout = {
                                title: 'Datorzinātnes, BSP',
                            };
                            Plotly.newPlot('tester', {!! $trace !!}, layout);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
