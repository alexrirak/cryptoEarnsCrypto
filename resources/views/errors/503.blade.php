<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="author" content="Alex Rirak">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crypto Earns Crypto - Goodbye</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BeamPipe -->
    <script async defer src="https://beampipe.io/js/tracker.js" data-beampipe-domain="cryptoearnscrypto.com"></script>

    <!-- MicroAnalytics -->
    <script data-host="https://app.microanalytics.io" data-dnt="false" src="https://app.microanalytics.io/js/script.js" id="ZwSg9rf6GA" async defer></script>

</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-lg justify-content-center">
        <a class="navbar-brand" href="{{ config('app.url') }}">Crypto Earns Crypto</a>
    </div>
</nav>

<main class="container-lg">
    <div class="px-4 my-5 col-lg-6 mx-auto">
        <h1 class="display-5 fw-bold">It's time to say goodbye</h1>
        <div>
            <p class="lead">
                We regret to inform you that after a thoughtful consideration, we have decided to shut down the Crypto Earns Crypto website. We’ve been privileged to serve as a reliable source for tracking interest rates in the crypto space. However, due to recent developments, including the bankruptcy of Celsius and the discontinuation of Gemini Earn from Genesis, our platform no longer serves its intended purpose.
            </p>
            <p class="lead">
                We want to express our deepest gratitude to all of you who utilized our service. Your support has been invaluable, and we appreciate your loyalty.
            </p>
            <p class="lead">
                What’s Next:
                <ul>
                    <li>
                        <b>Rate Data Availability<sup>1</sup></b>: In case you are interested in the historical data we’ve collected, all the rate data is available for download below. Downloading the data will allow you to access this information after the website is taken offline.
                    </li>
                    <li>
                        <b>User Data Deletion</b>: Your privacy is essential to us. Rest assured that all user data will be permanently deleted. We respect your trust and take data protection seriously.
                    </li>
                </ul>
            </p>
            <p class="lead">
                Once again, thank you for being a part of the Crypto Earns Crypto journey, and we wish you all the best in your future crypto endeavors.
            </p>
            <p class="lead">
                Sincerely,<br/>
                The Crypto Earns Crypto Team
            </p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center my-4">
                <button type="button" class="btn btn-primary btn-lg px-4 gap-3" onclick="downloadRateData()">Rate Data Download</button>
            </div>
            <p class="text-muted" style="font-size: 0.7rem;">
                <sup>1</sup> {{ config('app.name') }} cannot guarantee the validity of the information found here. While we make reasonable efforts to include accurate and up to date information, we make no warranties as to the accuracy of the content and assume no liability or responsibility for an error or omission in the content. All information is provided as is and you understand that you are using any and all information available here at your own risk.
                <br/>
                The information provided on this website does not constitute investment advice, financial advice, trading advice, or any other sort of advice and you should not treat any of the website's content as such. {{ config('app.name') }} does not recommend that any cryptocurrency should be bought, sold, or held by you. Do conduct your own due diligence and consult your financial advisor before making any investment decisions. With any investment, your capital is at risk. Past performance is no guarantee of future results.
            </p>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function downloadRateData() {
        window.open('{{ asset('data/crypto_earns_crypto_rate_data_archive.csv') }}', '_blank');
        window.beampipe('rate-data-download');
        pa.track({name: 'rate-data-download'});
    }
</script>

</body>
</html>

