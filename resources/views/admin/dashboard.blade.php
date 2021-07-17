@extends('template')

@section('title', 'Admin Dashboard')

@section('styles')

    <style>
        .stat-card {
            text-align: center;
        }
        .card-stat-bg-img {
            position: absolute;
            top: 1.25rem;
            font-size: 4.3rem;
            color: rgba(0,0,0,.15);
            right: 1rem;
        }
    </style>
@endsection

@section('content')
    <div>
        <h1 class="text-center">Admin Dashboard</h1>

        <div class="d-flex justify-content-evenly flex-wrap my-3">
            <div class="card text-white bg-success mx-3 flex-md-fill">
                <div class="card-body stat-card">
                    <h3>{{ $usersCount }}</h3>
                    <p>Registered Users</p>
                    <i class="bi bi-people-fill card-stat-bg-img"></i>
                </div>
            </div>

            <div class="card text-white bg-success mx-3 flex-md-fill">
                <div class="card-body stat-card">
                    <h3>{{ $alertsCount }}</h3>
                    <p>Alerts Created</p>
                    <i class="bi bi-envelope-fill card-stat-bg-img"></i>
                </div>
            </div>

            <div class="card text-white bg-success mx-3 flex-md-fill">
                <div class="card-body stat-card">
                    <h3>{{ $favoritesCount }}</h3>
                    <p>Favorites Saved</p>
                    <i class="bi bi-star-fill card-stat-bg-img"></i>
                </div>
            </div>
        </div>


{{--        <div class="card mx-auto mt-3 content-card">--}}
{{--            <div class="card-body">--}}
{{--                <h4 class="card-title">Some Title</h4>--}}
{{--                <p class="card-text">--}}
{{--                    some text--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection