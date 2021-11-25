@extends('template')

@section('title', 'Migrate From Celsius Tracker')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#migrateAccount").click(function () {
                $("#dots").show();
                $("#lookupFailure").hide();
                $.ajax({
                    url: '{{ route('celsiusTracker-migrateUser', [$emailId]) }}',
                    type: 'PUT',
                    success: function (result) {
                        $("#migrationSuccess").show();
                        setTimeout(function () {
                            window.location.href = "{{ route('home') }}";
                        }, 5000);
                    }
                }).fail(function () {
                    $("#lookupFailure").show();
                }).always(function() {
                    $("#dots").hide();
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .coinLogo {
            width: 2em;
            height: 2em;
            margin: auto;
        }

        /**===== dots =====*/
        #dots {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            height: 35px;
            width: 170px;
            margin: -35px 0 0 -85px;
            z-index: 1;
        }

        #dots span {
            position: absolute;
            width: 35px;
            height: 35px;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 50%;
            -webkit-animation: dots 1s infinite ease-in-out;
            animation: dots 1s infinite ease-in-out;
        }

        #dots span:nth-child(1) {
            left: 0px;
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        #dots span:nth-child(2) {
            left: 45px;
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s;
        }

        #dots span:nth-child(3) {
            left: 90px;
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s;
        }

        #dots span:nth-child(4) {
            left: 135px;
            -webkit-animation-delay: 0.5s;
            animation-delay: 0.5s;
        }

        @keyframes dots {
            0% {
                -webkit-transform: translateY(0px);
                transform: translateY(0px);
                -webkit-transform: translateY(0px);
                transform: translateY(0px);
                background: #d62d20;
            }
            25% {
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                background: #ffa700;
            }
            50% {
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                background: #008744;
            }
            100% {
                -webkit-transform: translateY(0px);
                transform: translateY(0px);
                -webkit-transform: translateY(0px);
                transform: translateY(0px);
                background: #0057e7;
            }
        }

        @-webkit-keyframes dots {
            0% {
                -webkit-transform: translateY(0px);
                transform: translateY(0px);
                background: #d62d20;
            }
            25% {
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                background: #ffa700;
            }
            50% {
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                background: #008744;
            }
            100% {
                -webkit-transform: translateY(0px);
                transform: translateY(0px);
                background: #0057e7;
            }
        }

        /** END of dots */
    </style
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

                <div id="dots" style="display:none;">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <p class="card-text">
                    Here are the subscriptions we were able to find. Click the button below to migrate your account.
                </p>

                <ul class="list-group w-50 mx-auto mb-3">
                    @foreach ($subscriptions as $sub)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$sub->name}} ({{$sub->symbol}})
                            <span class="badge"><img class="coinLogo" src="{{$sub->image}}" alt="{{$sub->name}}" title="{{$sub->name}}"></span>
                        </li>
                    @endforeach
                </ul>

                <p class="card-text text-center">
                    <a href="#" class="btn btn-success" id="migrateAccount">Migrate Account</a>
                </p>

                <p class="card-text small">
                    Clicking 'Migrate Account' will create an account for you on CryptoEarnsCrypto and you will begin receiving price change alerts from
                    CryptoEarnsCrypto for the subscriptions listed above. Your Celsius Tracker account will be deleted and is not recoverable.
                </p>

                <p class="card-text text-center" style="margin-top: 4em;">
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home Page</a>
                </p>
            </div>
        </div>
    </div>
@endsection
