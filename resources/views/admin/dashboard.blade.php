@extends('template')

@section('title', 'User Stats Dashboard')

@section('styles')

    <style>
        .stat-card {
            text-align: center;
        }

        .card-stat-bg-img {
            position: absolute;
            top: 1.25rem;
            font-size: 4.3rem;
            color: rgba(0, 0, 0, .15);
            right: 1rem;
            z-index: 1;
        }

        .stat-card-text {
            z-index: 2;
            position: relative;
        }

        .panel-control-button {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 1.8rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>

    @if (!$errors->any())
        <script>

            const CHART_COLORS = {
                red: 'rgb(255, 99, 132)',
                orange: 'rgb(255, 159, 64)',
                yellow: 'rgb(255, 205, 86)',
                green: 'rgb(75, 192, 192)',
                blue: 'rgb(54, 162, 235)',
                purple: 'rgb(153, 102, 255)',
                grey: 'rgb(201, 203, 207)'
            };

            const NAMED_COLORS = [
                CHART_COLORS.red,
                CHART_COLORS.orange,
                CHART_COLORS.yellow,
                CHART_COLORS.green,
                CHART_COLORS.blue,
                CHART_COLORS.purple,
                CHART_COLORS.grey,
            ];

            function namedColor(index) {
                return NAMED_COLORS[index % NAMED_COLORS.length];
            }

            function getBarGraphConfig(dataArray) {
                return {
                    type: 'bar',
                    data: dataArray,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    },
                }
            }

            function getTimeBarGraphConfig(dataArray) {

                var barGraphConfig = getBarGraphConfig(dataArray);
                barGraphConfig['options']['scales'] = {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'day'
                                    }
                                }
                }
                return barGraphConfig;

            }

            $(document).ready(function () {
                var alertsByCoinChart = document.getElementById('alertsByCoinChart');
                var favoritesByCoinChart = document.getElementById('favoritesByCoinChart');
                var usersByDateChart = document.getElementById('usersByDateChart');

                const alertData = {
                    labels: {!! collect(array_keys(collect($alertsCountByCoin)->first()))->toJson() !!},
                    datasets: [
                            @foreach ($alertsCountByCoin as $provider)
                        {
                            label: '{{ array_keys($alertsCountByCoin)[$loop->index] }}',
                            data: {{ collect(array_values($provider))->toJson() }},
                            backgroundColor: namedColor({{ $loop->index }}),
                            borderColor: namedColor({{ $loop->index }}),
                        },
                        @endforeach
                    ]
                };

                const favoritesData = {
                    labels: {!! collect(array_keys(collect($favoritesCountByCoin)->first()))->toJson() !!},
                    datasets: [
                            @foreach ($favoritesCountByCoin as $provider)
                        {
                            label: '{{ array_keys($favoritesCountByCoin)[$loop->index] }}',
                            data: {{ collect(array_values($provider))->toJson() }},
                            backgroundColor: namedColor({{ $loop->index }}),
                            borderColor: namedColor({{ $loop->index }}),
                        },
                        @endforeach
                    ]
                };

                const usersData = {
                    labels: {!! collect(array_keys($usersCountByDate))->toJson() !!},
                    datasets: [
                        {
                            label: 'User Registrations',
                            data: {{ collect(array_values($usersCountByDate))->toJson() }},
                            backgroundColor: namedColor(0),
                            borderColor: namedColor(0),
                        },
                    ]
                };

                new Chart(alertsByCoinChart, getBarGraphConfig(alertData));
                new Chart(favoritesByCoinChart, getBarGraphConfig(favoritesData));
                new Chart(usersByDateChart, getTimeBarGraphConfig(usersData));

                $(".panel-control-button").click(function() {
                    if ($(this).find("i").hasClass("bi-dash-square")) {
                        $("#" + $(this).attr("data-chart")).parent().hide();
                        $(this).find("i").removeClass("bi-dash-square");
                        $(this).find("i").addClass("bi-plus-square");
                    } else {
                        $("#" + $(this).attr("data-chart")).parent().show();
                        $(this).find("i").removeClass("bi-plus-square");
                        $(this).find("i").addClass("bi-dash-square");
                    }
                })

            });

        </script>
    @endif
@endsection

@section('content')
    <div>
        <h1 class="text-center">User Stats Dashboard</h1>

        <div class="d-flex justify-content-evenly flex-column flex-sm-row flex-wrap my-3">
            <div class="card text-white bg-secondary mx-3 my-1 flex-fill">
                <div class="card-body stat-card">
                    <h3 class="stat-card-text">{{ $usersCount }}</h3>
                    <p class="stat-card-text">Registered Users</p>
                    <i class="bi bi-people-fill card-stat-bg-img"></i>
                </div>
            </div>

            <div class="card text-white bg-secondary mx-3 my-1 flex-fill">
                <div class="card-body stat-card">
                    <h3 class="stat-card-text">{{ $alertsCount }}</h3>
                    <p class="stat-card-text">Alerts Created</p>
                    <i class="bi bi-envelope-fill card-stat-bg-img"></i>
                </div>
            </div>

            <div class="card text-white bg-secondary mx-3 my-1 flex-fill">
                <div class="card-body stat-card">
                    <h3 class="stat-card-text">{{ $favoritesCount }}</h3>
                    <p class="stat-card-text">Favorites Saved</p>
                    <i class="bi bi-star-fill card-stat-bg-img"></i>
                </div>
            </div>
        </div>


        <div class="card mx-auto mt-3">
            <div class="card-body">
                <h4 class="card-title">Alerts by Coin</h4>
                <button type="button" class="btn btn-outline-secondary btn-sm panel-control-button" style="border: 0px;" data-chart="alertsByCoinChart">
                    <i class="bi bi-dash-square"></i>
                </button>
                <div class="chart-container" style="height:auto">
                    <canvas id="alertsByCoinChart"></canvas>
                </div>

            </div>
        </div>

        <div class="card mx-auto mt-3">
            <div class="card-body">
                <h4 class="card-title">Favorites by Coin</h4>
                <button type="button" class="btn btn-outline-secondary btn-sm panel-control-button" style="border: 0px;" data-chart="favoritesByCoinChart">
                    <i class="bi bi-dash-square"></i>
                </button>
                <div class="chart-container" style="height:auto">
                    <canvas id="favoritesByCoinChart"></canvas>
                </div>

            </div>
        </div>

        <div class="card mx-auto mt-3">
            <div class="card-body">
                <h4 class="card-title">Users by Registration Date</h4>
                <button type="button" class="btn btn-outline-secondary btn-sm panel-control-button" style="border: 0px;" data-chart="usersByDateChart">
                    <i class="bi bi-dash-square"></i>
                </button>
                <div class="chart-container" style="height:auto">
                    <canvas id="usersByDateChart"></canvas>
                </div>

            </div>
        </div>


    </div>
@endsection