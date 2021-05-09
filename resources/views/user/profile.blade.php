@extends('template')

@section('title', 'Profile')

@section('styles')
    <style>
        .stats {
            background: #f2f5f8 !important;
            color: #000 !important
        }

        .number-label {
            font-size: 10px;
            color: #a1aab9
        }

        .number {
            font-weight: 500
        }
    </style>
@endsection

@section('content')
    <div>
        <h1 class="text-center">Profile</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">

                <div class="card p-3 mx-auto mb-3" style="max-width: 28rem;">
                    <div class="d-flex align-items-center">
                        <div class="image d-none d-sm-block">
                            <svg width="5rem" height="5rem">
                                <rect width="100" height="100"fill="#aeaeae" />
                                <text x="50%" y="50%" text-anchor="middle" fill="white" font-size="16px" font-family="Arial" dy=".4em">
                                    {{ Auth::user()->initials() }}
                                </text>
                            </svg>
                        </div>
                        <div class="ms-3" style="width: 100%;">
                            <h4 class="mb-0 mt-0">{{ auth()->user()->name }}</h4> <span>{{ auth()->user()->email }}</span>
                            <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                                <div class="d-flex flex-column"> <span class="number-label">Email Alerts</span> <span class="number">{{ $user->alerts }}</span> </div>
                                <div class="d-flex flex-column"> <span class="number-label">Favorites</span> <span class="number">{{ $user->favorites }}</span> </div>
                                <div class="d-flex flex-column"> <span class="number-label">Member Since</span> <span class="number">{{ date('Y-m-d',strtotime($user->member_since)) }}</span> </div>
                            </div>
                            <div class="button mt-2 d-flex flex-row align-items-center">
                                <a href="{{ route('unsubscribe', ["emailId"=>bin2hex($user->email)]) }}" class="btn btn-sm btn-outline-secondary w-100 me-1">Unsubscribe</a>
                                <a class="btn btn-sm btn-danger w-100 ms-1" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</a>
                            </div>
                        </div>
                    </div>
                </div>


                <p class="card-text text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">Go Back</a>
                </p>
            </div>
        </div>

    </div>
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <h5>This will remove your account and all associated data!</h5>
                        <b>This action is irreversible, if you change your mind you will need to create a new account.</b>
                    </div>
                    <p>You will stop receiving any alerts you have subscribed to.</p>
                    <p><b>Are you sure you want to proceed?</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a type="button" class="btn btn-danger" href="{{ route('delete-user') }}">Delete Account</a>
                </div>
            </div>
        </div>
    </div>
@endsection
