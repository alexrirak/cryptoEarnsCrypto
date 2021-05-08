@extends('template')

@section('title', 'Delete Account')

@section('content')
    <div>
        <h1 class="text-center">Delete Account</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">

                <h4 class="card-title mb-2">We are sorry to see you go</h4>

                <p class="card-text">
                <div class="alert alert-secondary" role="alert">
                    <h4 class="alert-heading">Your account has been queued for deletion!</h4>
                    <p>It can take up to 30 min (though usually much less) for all your data to be removed from our system. This action is irreversible, if
                        you change your mind you will need to create a new account.</p>
                </div>
                </p>


                <p class="card-text text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                </p>
            </div>
        </div>

    </div>
@endsection