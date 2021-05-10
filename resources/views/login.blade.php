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
                <div class="d-flex flex-column justify-content-center">
                    <div class="btn-group google-btn mx-auto p-1">
                        <a href="{{ route('login-provider', ['provider'=>'google']) }}" class="btn" style="font-size: x-large;"><i class="bi bi-google"></i></a>
                        <a href="{{ route('login-provider', ['provider'=>'google']) }}" class="btn" style="width: 184px;">Sign In With Google</a>
                    </div>

                    <div class="btn-group facebook-btn mx-auto p-1">
                        <a href="{{ route('login-provider', ['provider'=>'facebook']) }}" class="btn" style="font-size: x-large;"><i class="bi bi-facebook"></i></a>
                        <a href="{{ route('login-provider', ['provider'=>'facebook']) }}" class="btn" style="width: 184px;">Sign In With Facebook</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
