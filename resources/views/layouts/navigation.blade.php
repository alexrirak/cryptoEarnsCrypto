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
                        @foreach (\App\Models\ProviderMetadata::all() as $provider)
                            <li><a class="dropdown-item" href="{{ route('rates',['provider' => Str::lower($provider->name)]) }}">{{ $provider->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><hr class="dropdown-divider"></li>
                @auth
                    <li class="nav-item d-md-none">
                        <a class="nav-link" aria-current="page" href="{{ route('subscriptions') }}">Manage Alerts</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" aria-current="page" href="{{ route('profile') }}">Profile</a>
                    </li>
                    @if ( Auth::user()->isAdmin )
                        <li><hr class="dropdown-divider"></li>
                        <li class="nav-item d-md-none">
                            <a class="nav-link" aria-current="page" href="{{ route('admin-dashboard') }}">User Stats Dashboard</a>
                        </li>
                    @endif
                    <li class="nav-item d-md-none">
                        <a class="nav-link" aria-current="page" href="{{ route('logout') }}">Sign out</a>
                    </li>
                @else
                    <li class="nav-item d-md-none">
                        <a class="nav-link" aria-current="page" href="{{ route('signin') }}">Sign-In</a>
                        <a class="nav-link" aria-current="page" href="{{ route('signup') }}">Sign-Up</a>
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
                            <li><a class="dropdown-item" href="{{ route('subscriptions') }}">Manage Alerts</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            @if ( Auth::user()->isAdmin )
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin-dashboard') }}">User Stats Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-outline-light me-2" href="{{ route('signin') }}" role="button">Sign-In</a>
                    <a class="btn btn-warning" href="{{ route('signup') }}" role="button">Sign-Up</a>
                @endauth
            </div>
        </div>

    </div>
</nav>
