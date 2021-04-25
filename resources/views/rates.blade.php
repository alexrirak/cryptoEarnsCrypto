@extends('template')

@section('title', 'Home')

@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @include('rates-js')
@endsection

@section('styles')
    <link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('css/rates.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="text-center">
        <h1 data-provider="{{ Str::lower($provider) }}" data-provider-rate="{{ $providerMetaData->specialRateName }}">{{ Str::ucfirst($provider) }} APY Tracker</h1>
        <div class="alert alert-success" role="alert" id="signupSuccess" style="display: none;">
            <h4 class="alert-heading"><i class="bi bi-check-square"></i> You have been registered for alerts!</h4>
            <p>If this is your first time signing up you will need to confirm your email first. Check your email for your confirmation link.</p>
        </div>
        <div class="alert alert-danger" role="alert" id="signupFailure" style="display: none;">
            <h4 class="alert-heading"><i class="bi bi-x-square"></i> Something went wrong!</h4>
            <p>We were not able to register you for alerts. Please try again later. If this problem persist please contact us.</p>
        </div>
        <table id="rateTable" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th>Coin</th>
                    <th>Name</th>
                    <th>Ticker</th>
                    @auth <th>Favorites</th> @endauth
                    <th>Current Rate</th>
                    <th>Prior Rate</th>
                    <th>Change</th>
                    <th>Change Date</th>
                </tr>
            </thead>
        </table>
    </div>
    @guest
    <div class="modal fade" id="favoriteModal" tabindex="-1" aria-labelledby="favoriteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="favoriteModalLabel">
                        {{ __('favorites.account-required') }}
                    </h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                    <div>
                        <a class="btn btn-outline-secondary" href="{{ route('login') }}" role="button">Login</a>
                        <a class="btn btn-outline-secondary" href="{{ route('login') }}" role="button">Sign-up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest
@endsection
