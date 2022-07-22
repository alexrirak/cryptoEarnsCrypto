<div class="js-cookie-consent cookie-consent fixed-bottom bg-success px-2 py-5 text-light text-center">

    <span class="cookie-consent__message">
        {!! trans('cookie-consent::texts.message', ['cookie-url' => route('cookie-policy') ]) !!}
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree btn btn-sm btn-outline-light">
        {{ trans('cookie-consent::texts.agree') }}
    </button>

</div>
