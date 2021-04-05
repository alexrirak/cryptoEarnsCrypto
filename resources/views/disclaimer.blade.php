@extends('template')

@section('title', 'Disclaimer')

@section('styles')
<style>
    .disclaimer-card {
        width: 100%;
    }
    @media (min-width: 767px) {
        .disclaimer-card {
            width: 75%;
        }
    }
</style>
@endsection



@section('content')
    <div>
        <h1 class="text-center">Disclaimer</h1>

            <div class="card mx-auto mt-3 disclaimer-card">
                <div class="card-body">
                    <h4 class="card-title">Not Investment Advice</h4>

                    <p class="card-text">
                        The information provided on this website does not constitute investment advice, financial advice, trading advice, or any other sort of advice and you should not treat any of the website's content as such. {{ config('app.name') }} does not recommend that any cryptocurrency should be bought, sold, or held by you. Do conduct your own due diligence and consult your financial advisor before making any investment decisions. With any investment, your capital is at risk. Past performance is no guarantee of future results.
                    </p>

                    <h4 class="card-title">Accuracy of Information</h4>

                    <p class="card-text">
                        {{ config('app.name') }} cannot guarantee the validity of the information found here. While we make reasonable efforts to include accurate and up to date information, we make no warranties as to the accuracy of the content and assume no liability or responsibility for an error or omission in the content. All information is provided as is and you understand that you are using any and all information available here at your own risk.
                    </p>

                    <h4 class="card-title">Non Endorsement</h4>

                    <p class="card-text">
                        All product and company names and logos are trademarks™ or registered® trademarks of their respective holders. Use of them does not imply any affiliation with or endorsement by them. The appearance of third party names and logos on {{ config('app.name') }} does not constitute an endorsement, guarantee, warranty, or recommendation by {{ config('app.name') }}. Conduct your own due diligence.
                    </p>

                    <p class="card-text text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary">Go Back</a>
                    </p>
                </div>
            </div>

    </div>
@endsection
