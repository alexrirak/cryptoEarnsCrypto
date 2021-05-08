@extends('template')

@section('title', 'Privacy Center')

@section('content')
    <div>
        <h1 class="text-center">Privacy Center</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">
                <h4 class="card-title">Manage Your Email Preferences</h4>

                <p>To manage your email preferences for coin alerts, first log in to your account. Then use the "Manage Alerts" button on the main page to
                    change your subscriptions. You can also use the unsubscribe on the <a href="{{ route('profile') }}">profile page</a> or use the unsubscribe link in our emails.</p>

                <h4 class="card-title">Delete My Data</h4>

                <p>To delete your data, first log in to your account. Then navigate to the <a href="{{ route('profile') }}">profile page</a> and use the "Delete my Account" button.</p>

                <h4 id="cookie-policy" class="card-title">Cookie Policy</h4>

                <div class="card mb-2">
                    <h5 class="card-header">Introduction</h5>
                    <div class="card-body">
                        <p class="card-text">A cookie is a small data file made up of letters and numbers which is placed by a website on the device you use to
                            access the internet. Cookies serve different purposes. We use cookies to help us to improve our site and to provide us with
                            information about usage of the website. Certain third parties also place cookies on your device when you browse our website.
                        </p>
                        <p class="card-text">Most web browsers allow some control over the placing of cookies on your device through your browser settings.
                            {{ config('app.name') }} supports the “Do Not Track” setting provided by most web browsers, which allows you to opt-out of your
                            online behavior being tracked while visiting our websites. Our system may place cookies on your device when you visit any page on
                            our website unless you have adjusted your browser settings to not accept cookies.
                        </p>
                    </div>
                </div>

                <div class="card mb-2">
                    <h5 class="card-header">Types Of Cookies Used By {{ config('app.name') }}</h5>
                    <div class="card-body">
                        <h5 class="card-title">Session Cookies</h5>
                        <p class="card-text">“User input cookies”, or session cookies, are used to keep track of a user’s input when submitting online data and
                            allow users to be recognized from one page or selection to another. We also use session cookies to provide information you’ve
                            requested through an action , such as clicking a button or filling out a web form. Session cookies always expire after the browsing
                            session is over.
                        </p>
                        <h5 class="card-title">Persistent Cookies</h5>
                        <p class="card-text">Persistent cookies help websites remember your information, browsing history, and settings when you visit them in
                            the future. This results in faster and more convenient access. Persistent cookies stay in a folder on your device unless you delete
                            them manually, or until they are automatically deleted based on the retention period of the cookie’s folder.
                        </p>
                        <h5 class="card-title">Third Party Analytics Cookies</h5>
                        <p class="card-text">We use the Analytical cookies of Google Analytics service to analyse the use of our website and keep track of
                            visitors. Google Analytics generate statistical and other information about our website’s use. Details and privacy policy of Google
                            analytics cookies can be found <a href="https://www.google.com/intl/en/policies/technologies/types/" target="_blank">on their
                                website</a>.
                        </p>
                    </div>
                </div>

                <div class="card mb-2">
                    <h5 class="card-header">Blocking Or Deleting Cookies</h5>
                    <div class="card-body">
                        <p class="card-text">You may refuse to accept cookies or delete cookies already stored on your computer through the settings of your web
                            browser. Blocking and deleting cookies may have a negative impact upon the usability of our website and you might be prevented from
                            using all the features available on our website.
                        </p>
                        <ul>
                            <li><a href="https://support.google.com/chrome/answer/95647?hl=en">Google Chrome</a></li>
                            <li><a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer">Firefox</a></li>
                            <li><a href="https://support.microsoft.com/en-us/help/17442/windows-internet-explorer-delete-manage-cookies#ie=ie-11">Internet
                                    Explorer</a></li>
                            <li><a href="https://support.apple.com/en-gb/HT201265">Safari</a></li>
                        </ul>
                        <p class="card-text">
                            <b><i>By continuing to browse our Website, you hereby consent to this Cookie Policy regardless of your browser settings.</i></b>
                        </p>
                    </div>
                </div>

                <p class="card-text text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">Go Back</a>
                </p>
            </div>
        </div>

    </div>
@endsection