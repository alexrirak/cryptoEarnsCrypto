@extends('template')

@section('title', 'Login with Email')

@section('styles')
    <link href="{{ asset('css/email-login.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div>
        <h1 class="text-center">Login with Email</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">

                <div class="d-flex flex-column justify-content-center">

                    @if(!session()->has('success'))

                        <div class="form-signin">
                            <form action="{{ route('email-login') }}" method="post">
                                <h5 class="h5 mb-3 fw-normal" style="text-align: center;">Enter the email address associated with your account, and we’ll send a magic link to your inbox.</h5>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @csrf
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                                    <label for="floatingInput">Email address</label>
                                </div>

    {{--                            <div class="checkbox mb-3">--}}
    {{--                                <label>--}}
    {{--                                    <input type="checkbox" value="remember-me"> Remember me--}}
    {{--                                </label>--}}
    {{--                            </div>--}}
                                <button class="w-100 btn btn-lg btn-secondary" type="submit">Continue</button>
                                <p class="mt-5 mb-3" style="text-align: center;">
                                    <a href="{{ route('login') }}" class="text-muted return-link" style="text-decoration: none;">
                                        <i class="bi bi-arrow-return-left"></i> Other sign in options
                                    </a>
                                </p>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-secondary" role="alert" style="text-align: center;">
                            Please click the link sent to your email to finish logging in
                        </div>
                        <a href="{{ route('home') }}">
                            <button class="w-100 btn btn-lg btn-outline-secondary" type="buttn">Go Back</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection