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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <a href="{{ route('login-provider', ['provider'=>'google']) }}" class="google-btn">
                    <div class="mx-auto"></div>
                </a>
                <a href="{{ route('login-provider', ['provider'=>'facebook']) }}" class="facebook-btn">
                    <div class="mx-auto"></div>
                </a>
            </div>
        </div>

    </div>
@endsection
