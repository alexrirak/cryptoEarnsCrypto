@extends('auth.template')

@section('type', 'Sign In')

@section('buttons')
    <div class="btn-group email-btn mx-auto p-1">
        <a href="{{ route('email-login') }}" class="btn" style="font-size: x-large;"><i class="bi bi-at"></i></a>
        <a href="{{ route('email-login') }}" class="btn" style="width: 193px;">@yield('type') With Email</a>
    </div>
@endsection

@section('jump-link')
    <p class="mt-5 mb-3" style="text-align: center;">
        Need an account?
        <a href="{{ route('signup') }}" class="text-muted jump-link" style="text-decoration: none;">
            <b>Create One</b>
        </a>
    </p>
@endsection
