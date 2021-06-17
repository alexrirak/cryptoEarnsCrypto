@extends('template')

@section('title', 'History')

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>

    <script>
        $(document).ready(function () {
            var ctx = document.getElementById('rateChart');
            const data = {
                labels: ['2021-03-30 04:33:22', '2021-04-30 04:33:22', '2021-05-30 04:33:22', '2021-06-16 04:33:22'],
                datasets: [
                    {
                        label: '{{ $coinMetaData->symbol }}',
                        data: [3.51, 7.25, 10.51, 7.50],
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
                                text: 'Change Date'
                            },
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