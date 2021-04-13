@extends('template')

@section('title', 'Login')

@section('styles')
    <link href="{{ asset('css/social.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div>
        <h1 class="text-center">Login / Sign Up</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">
                <a href="{{ route('login-provider', ['provider'=>'google']) }}" class="google-btn">
                    <div id="google-btn" class="mx-auto"></div>
                </a>
            </div>
        </div>

    </div>
@endsection
