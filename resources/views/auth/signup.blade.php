@extends('auth.template')

@section('type', 'Sign Up')

@section('jump-link')
    <p class="mt-5 mb-3" style="text-align: center;">
        Have an account?
        <a href="{{ route('signin') }}" class="text-muted jump-link" style="text-decoration: none;">
            <b>Sign in</b>
        </a>
    </p>
@endsection
