<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="author" content="Alex Rirak">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Crypto Earns Crypto - @yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('styles')

    </head>

    <body>
        @if (Str::lower(config('app.env'))=='local')
            <div class="corner-ribbon top-left sticky green shadow" style="z-index: 9999;">{{ Str::upper(config('app.env')) }}</div>
        @elseif (Str::lower(config('app.env'))!='production')
            <div class="corner-ribbon top-left sticky orange shadow" style="z-index: 9999;">{{ Str::upper(config('app.env')) }}</div>
        @endif


        @include('cookieConsent::index')

        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-lg">
                    <a class="navbar-brand" href="{{ config('app.url') }}">Crypto Earns Crypto</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    APY Trackers
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Celsius</a></li>
                                    <li><a class="dropdown-item" href="#">Another Provider</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @auth
                                <li class="nav-item d-md-none">
                                    <a class="nav-link" aria-current="page" href="{{ route('logout') }}">Sign out</a>
                                </li>
                            @else
                                <li class="nav-item d-md-none">
                                    <a class="nav-link" aria-current="page" href="{{ route('login') }}">Login / Sign-up</a>
                                </li>
                            @endauth
                        </ul>

                        <div class="d-flex d-none d-md-block">
                            @auth
                                <div class="flex-shrink-0 dropdown">
                                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="32" height="32">
                                            <circle cx="16" cy="16" r="16" fill="#aeaeae" />
                                            <text x="50%" y="50%" text-anchor="middle" fill="white" font-size="16px" font-family="Arial" dy=".4em">{{ Auth::user()->initials() }}</text>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                        <li><a class="dropdown-item" href="#">New project...</a></li>
                                        <li><a class="dropdown-item" href="#">Settings</a></li>
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                                    </ul>
                                </div>
                            @else
                                <a class="btn btn-outline-light me-2" href="{{ route('login') }}" role="button">Login</a>
                                <a class="btn btn-warning" href="{{ route('login') }}" role="button">Sign-up</a>
                            @endauth
                        </div>
                    </div>

            </div>
        </nav>

        <main class="container-lg">

            @yield('content')

            <div class="alert alert-light" id="disclaimer">
                @section('disclaimer')
                This website is not affiliated with any of the listed networks. All logos property of their respective owners.
                @show
                <br /><br />
                <a href="/unsubscribe" >[Unsubscribe]</a> <i class="bi bi-three-dots"></i> <a href="{{ route('disclaimer') }}" >[Disclaimer]</a> <i class="bi bi-three-dots"></i> <a href="{{ route('support-us') }}" >[Support Us]</a>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        @yield('scripts')

    </body>
</html>
