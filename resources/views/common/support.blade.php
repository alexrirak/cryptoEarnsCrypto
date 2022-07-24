@extends('template')

@section('title', 'Support Us')

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/supportUs.js') }}"></script>
@endsection



@section('content')
    <div>
        <h1 class="text-center">Support Us</h1>

            <div class="card mx-auto mt-3 content-card">
                <div class="card-body">
                    <h4 class="card-title">Wallet Addresses</h4>
                    <p class="card-text">
                        Thank you for visiting our website! As you may have noticed, we do not have any ads, so we do not make any money from this website. If you found this helpful and would like to donate to support it, you can use the addresses below:
                    </p>

                    <div class="input-group mb-3">
                        <span class="input-group-text" style="font-weight: bold;">ETH/ERC-20</span>
                        <input type="text" class="form-control" aria-label="ETH" id="eth-address" value="0x4Ec60f39094680B4D31a2D46C2B541047455dd0f" disabled>
                        <span class="input-group-text"><button type="button" id="eth-copy" class="btn btn-outline-secondary btn-sm" data-bs-placement="bottom" title="Copied!">COPY</button></span>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" style="font-weight: bold;">BTC</span>
                        <input type="text" class="form-control" aria-label="BTC" id="btc-address" value="bc1quq0095agyk38e8ptfl7nj4c7z4a2hgp7y9hlzh" disabled>
                        <span class="input-group-text"><button type="button" id="btc-copy" class="btn btn-outline-secondary btn-sm" data-bs-placement="bottom" title="Copied!">COPY</button></span>
                    </div>

                    <h4 class="card-title">Contact Us</h4>
                    <p class="card-text">If you need to contact us you can reach out to <i>hi<!---->@<!---->crypto<!---->earns<!---->crypto<!---->.com</i></p>

                    <p class="card-text text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary">Go Back</a>
                    </p>
                </div>
            </div>
    </div>
@endsection
