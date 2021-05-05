@extends('template')

@section('title', 'Unsubscribe')

@section('scripts')

    @if ($userAlertsCount != 0)
        <script>
            $(document).ready(function () {

                $("#unsubscribeButton").click(function () {
                    $.ajax({
                        url: "{{ route('unsubscribe-process', [$emailId]) }}",
                        type: 'DELETE',
                        success: function () {
                            $("#unsubscribeSuccess").show();
                        }
                    }).fail(function () {
                        $("#unsubscribeFailure").show();
                    }).always(function () {
                        $("#unsubscribeButton").hide();
                        setTimeout(function () {
                            window.location = "{{ route('home') }}"
                        }, 8000);
                    });
                });

            });
        </script>
    @endif

@endsection

@section('content')
    <div>
        <h1 class="text-center">Unsubscribe?</h1>

        @if ($userAlertsCount === 0)

            <div class="alert alert-danger" role="alert" id="signupFailure">
                <h4 class="alert-heading"><i class="bi bi-x-square"></i> Oops! Something went wrong!</h4>
                <p>Please confirm you entered the correct URL or try again later. If this problem persist please contact us.</p>
                <p><a href="{{ route('home') }}">Click here to go back to the main page</a></p>
            </div>

        @else

            <div class="card mx-auto mx-sm-2 mt-3">
                <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">Do you really want to unsubscribe?</h4>

                    <div class="alert alert-success" role="alert" id="unsubscribeSuccess" style="display: none;">
                        <h4 class="alert-heading"><i class="bi bi-check-square"></i> You have been unsubscribed!</h4>
                        <p>If you change your mind you can sign up again via the main page.</p>
                        <p><a href="{{ route('home') }}">Click here to go back to the main page</a></p>
                    </div>

                    <div class="alert alert-danger" role="alert" id="unsubscribeFailure" style="display: none;">
                        <h4 class="alert-heading"><i class="bi bi-x-square"></i> Oops! Something went wrong!</h4>
                        <p>Please refresh the page or try again later. If this problem persist please contact us.</p>
                        <p><a href="{{ route('home') }}">Click here to go back to the main page</a></p>
                    </div>

                    <p class="card-text">You are currently subscribed as <b style='font-family: "Lucida Console", "Courier New", monospace;'>{{ $email }}</b> to
                        <b style='font-family: "Lucida Console", "Courier New", monospace;'>{{ $userAlertsCount }}</b> alerts.</p>

                    <div class="alert alert-warning mb-3" style="max-width: 800px;margin: auto;" role="alert">
                        <h4 class="alert-heading">Warning!</h4>
                        <p>This will unsubscribe you from all the alerts you are currently subscribed to. If you would instead like to change which coins you
                            get alerts for you can do so from the main page.</p>
                    </div>

                    <a href="#" class="btn btn-danger" id="unsubscribeButton">Unsubscribe</a>
                    <a href="{{ route('home') }}" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        @endif


    </div>
@endsection
