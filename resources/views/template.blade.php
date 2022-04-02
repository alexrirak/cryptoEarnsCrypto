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

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-RTD1DPSRHB"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-RTD1DPSRHB');
        </script>
        
        <!-- BeamPipe -->
        <script async defer src="https://beampipe.io/js/tracker.js" data-beampipe-domain="cryptoearnscrypto.com"></script>

    </head>

    <body>
        @if (Str::lower(config('app.env'))=='local')
            <div class="corner-ribbon top-left sticky green shadow" style="z-index: 9999;" onclick="$(this).hide();">{{ Str::upper(config('app.env')) }}</div>
        @elseif (Str::lower(config('app.env'))!='production')
            <div class="corner-ribbon top-left sticky orange shadow" style="z-index: 9999;" onclick="$(this).hide();">{{ Str::upper(config('app.env')) }}</div>
        @endif


        @include('cookieConsent::index')

        @include('layouts.navigation')

        <main class="container-lg">

            @yield('content')

            <div class="alert alert-light" id="disclaimer">
                @section('disclaimer')
                This website is not affiliated with any of the listed networks. All logos property of their respective owners.
                @show
                <br /><br />
                <a href="{{ route('privacy-center') }}" >[Privacy Center]</a> <i class="bi bi-three-dots"></i> <a href="{{ route('disclaimer') }}" >[Disclaimer]</a> <i class="bi bi-three-dots"></i> <a href="{{ route('support-us') }}" >[Support Us]</a>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        @yield('scripts')

    </body>
</html>
