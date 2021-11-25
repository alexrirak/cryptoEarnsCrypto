@extends('template')

@section('title', 'Migrate From Celsius Tracker')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#migrateAccount").click(function() {
                $("#lookupFailure").hide();
                $.ajax({
                    url: '{{ route('celsiusTracker-migrateUser', [$emailId]) }}',
                    type: 'PUT',
                    success: function(result) {
                        $("#migrationSuccess").show();
                        setTimeout(function() {
                            window.location.href = "{{ route('home') }}";
                        }, 5000);
                    }
                }).fail(function() {
                    $("#lookupFailure").show();
                });
            });
        });
    </script>
@endsection


@section('content')
    <div>
        <h1 class="text-center">Migrate From Celsius Tracker</h1>

            <div class="card mx-auto mt-3 content-card">
                <div class="card-body">
                    <h4 class="card-title">We found your account!</h4>

                    <div class="alert alert-danger" role="alert" id="lookupFailure" style="display: none;">
                        <h4 class="alert-heading"><i class="bi bi-x-square"></i> Oops! Something went wrong!</h4>
                        <p>Please try again later. If this problem persist please contact us.</p>
                    </div>

                    <div class="alert alert-success" role="alert" id="migrationSuccess" style="display: none;">
                        <h4 class="alert-heading"><i class="bi bi-x-square"></i> Success! Account Migrated!</h4>
                        <p>Your account has been migrated. You can now use the login page to access your account.</p>
                        <p>Redirecting you to the home page...</p>
                    </div>

                    <p class="card-text">
                        Here are the subscriptions we were able to find. Click the button below to migrate your account.
                    </p>

                    <ul>
                        @foreach ($subscriptions as $sub)
                            <li>{{$sub}}</li>
                        @endforeach
                    </ul>

                    <p class="card-text">
                        <a href="#" class="btn btn-success" id="migrateAccount">Migrate Account</a>
                    </p>

                    <p class="card-text small">
                        Clicking 'Migrate Account' will create an account for you on CryptoEarnsCrypto and you will begin receiving price change alerts from CryptoEarnsCrypto for the subscriptions listed above. Your Celsius Tracker account will be deleted and is not recoverable.
                    </p>

                    <p class="card-text text-center" style="margin-top: 4em;">
                        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home Page</a>
                    </p>
                </div>
            </div>
    </div>
@endsection
