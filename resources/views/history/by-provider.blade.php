@extends('template')

@section('title', 'History')

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>

    <script>
        $(document).ready(function () {
            var ctx = document.getElementById('rateChart');
            const data = {
                labels: [@foreach ($labels as $label) "{{$label}}"@if (!$loop->last),@endif @endforeach],
                datasets: [
                    {
                        label: '{{ $coinMetaData->symbol }}',
                        data: [@foreach ($data as $data_elm) {{$data_elm}}@if (!$loop->last),@endif @endforeach],
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                        stepped: true,
                    }
                ]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                        axis: 'x'
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Change Date',
                            },
                            type: 'time',
                            time: {
                                unit: 'week'
                            },
                            ticks: {
                                source: 'data'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'APY'
                            },
                            suggestedMin: 0
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>

@endsection

@section('styles')

@endsection

@section('content')

    <div>
        <h1 class="text-center">{{ $providerMetaData->name }} APY History</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">
                <h4 class="card-title">{{ $coinMetaData->symbol }} History</h4>

                <canvas id="rateChart"></canvas>

            </div>
        </div>

    </div>

@endsection