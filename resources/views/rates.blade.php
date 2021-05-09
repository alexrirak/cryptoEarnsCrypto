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
        <table id="rateTable" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th>Coin</th>
                    <th>Name</th>
                    <th>Ticker</th>
                    @auth <th>Favorites</th> @endauth
                    @auth <th>Alerts</th> @endauth
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
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">
                        {{ __('notifications.account-required') }}
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
