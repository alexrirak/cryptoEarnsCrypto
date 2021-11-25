@extends('template')

@section('title', 'Migrate From Celsius Tracker')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#accountLookup").click(function () {
                $("#lookupFailure").hide();

                let email = $("#migrationEmail").val();
                if (email == "") {
                    $("#lookupFailure").show();
                    return;
                }

                $.get("{{ route('celsiusTracker-userLookup', [$emailId='']) }}/" + email, function(data, status){
                    if(status != "success" || 0 == data) {
                        $("#lookupFailure").show();
                    } else {
                        window.location.href = "{{ route('celsiusTrackerMigration-migrate', [$emailId='']) }}/" + email;
                    }
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
                    <h4 class="card-title">Welcome to Crypto Earns Crypto!</h4>
                    <p class="card-text">
                        We are extremely happy that you have decided to migrate over to our new website. Please enter your email address below and then click the green button so that we can lookup your account:
                    </p>

                    <div class="alert alert-danger" role="alert" id="lookupFailure" style="display: none;">
                        <h4 class="alert-heading"><i class="bi bi-x-square"></i> Oops! Something went wrong!</h4>
                        <p>We could not find your account. If you have already migrated your account you will not be able to migrate it again.</p>
                        <p>Please confirm you entered your email correctly or try again later. If this problem persist please contact us.</p>
                    </div>

                    <div class="mb-3">
                        <input type="email" class="form-control" id="migrationEmail" placeholder="name@example.com">
                    </div>

                    <p class="card-text text-center">
                        <a href="#" class="btn btn-success" id="accountLookup">Lookup Account</a>
                    </p>

                    <p class="card-text text-center" style="margin-top: 4em;">
                        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home Page</a>
                    </p>
                </div>
            </div>
    </div>
@endsection
