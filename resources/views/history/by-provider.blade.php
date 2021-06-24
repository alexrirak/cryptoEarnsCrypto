@extends('template')

@section('title', 'History')

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>

    @if (!$errors->any())
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
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (item) {
                                        return item.dataset.label + ": " + item.formattedValue + "%";
                                    }
                                }
                            }
                        },
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
                                    source: '@if (count($labels) < 3){{"data"}}@else{{"auto"}}@endif'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'APY (%)'
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, config);
            });
        </script>
    @endif

@endsection

@section('styles')

@endsection

@section('content')

    <div>
        <h1 class="text-center">{{ $providerMetaData->name }} APY History</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">
                <h4 class="card-title">{{ $coinMetaData->symbol }} History</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <canvas id="rateChart"></canvas>
                @endif

                <p class="card-text text-center mt-2">
                    <a href="{{ route('rates',["provider" => $providerMetaData->name]) }}" class="btn btn-primary">Back To APY Tracker</a>
                </p>

            </div>
        </div>

    </div>

@endsection