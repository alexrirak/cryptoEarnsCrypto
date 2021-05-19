@extends('template')

@section('title', 'Manage Subscriptions')

@section('scripts')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {

            // handle favorite button click for each coin
            $("[data-type='favorite']").click(function() {
                if ($(this).find("i").hasClass("bi-star-fill")) {

                    //already in favorites, so remove it
                    $(this).find("i").removeClass("bi-star-fill");
                    $(this).find("i").addClass("bi-hourglass-split");

                    var element = this;

                    $.ajax({
                        url: '{{ route('deleteFavorite', ['provider' => '-provider-', 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'
                            .replace("-coin-", $(this).attr('data-coin'))
                            .replace("-provider-", $(this).attr('data-provider')),
                        type: 'DELETE',
                        success: function () {
                            $(element).find("i").removeClass("bi-hourglass-split");
                            $(element).find("i").addClass("bi-star");
                            favoriteRemovedToast($(element).attr('data-coin'),$(element).attr('data-provider'));
                        }
                    }).fail(function () {
                        favoriteErrorToast();
                        //revert to original state
                        $(element).find("i").removeClass("bi-hourglass-split");
                        $(element).find("i").addClass("bi-star-fill");
                    });

                } else {
                    //add to favorites
                    $(this).find("i").removeClass("bi-star");
                    $(this).find("i").addClass("bi-hourglass-split");

                    var element = this;

                    $.ajax({
                        url: '{{ route('addFavorite', ['provider' => '-provider-', 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'
                            .replace("-coin-", $(this).attr('data-coin'))
                            .replace("-provider-", $(this).attr('data-provider')),
                        type: 'PUT',
                        success: function () {
                            $(element).find("i").removeClass("bi-hourglass-split");
                            $(element).find("i").addClass("bi-star-fill");
                            favoriteAddedToast($(element).attr('data-coin'),$(element).attr('data-provider'));
                        }
                    }).fail(function () {
                        favoriteErrorToast();
                        //revert to original state
                        $(element).find("i").removeClass("bi-hourglass-split");
                        $(element).find("i").addClass("bi-star");
                    });
                }
            })

            // handle alert button click for each coin
            $("[data-type='alert']").click(function() {
                if ($(this).find("i").hasClass("bi-envelope-fill")) {
                    //already in alerts, so remove it

                    $(this).find("i").removeClass("bi-envelope-fill");
                    $(this).find("i").addClass("bi-hourglass-split");


                    var element = this;

                    $.ajax({
                        url: '{{ route('deleteAlert', ['provider' => '-provider-', 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'
                            .replace("-coin-", $(this).attr('data-coin'))
                            .replace("-provider-", $(this).attr('data-provider')),
                        type: 'DELETE',
                        success: function () {
                            $(element).find("i").removeClass("bi-hourglass-split");
                            $(element).find("i").addClass("bi-envelope");
                            alertRemovedToast($(element).attr('data-coin'), $(element).attr('data-provider'));
                        }
                    }).fail(function () {
                        alertErrorToast();
                        //revert to original state
                        $(element).find("i").removeClass("bi-hourglass-split");
                        $(element).find("i").addClass("bi-envelope-fill");
                    });

                } else {
                    //add to alerts
                    $(this).find("i").removeClass("bi-envelope");
                    $(this).find("i").addClass("bi-hourglass-split");

                    var element = this;

                    $.ajax({
                        url: '{{ route('addAlert', ['provider' => '-provider-', 'coin' => '-coin-']) . "?api_token=" . Auth::user()->id }}'
                            .replace("-coin-", $(this).attr('data-coin'))
                            .replace("-provider-", $(this).attr('data-provider')),
                        type: 'PUT',
                        success: function () {
                            $(element).find("i").removeClass("bi-hourglass-split");
                            $(element).find("i").addClass("bi-envelope-fill");
                            alertAddedToast($(element).attr('data-coin'), $(element).attr('data-provider'))
                        }
                    }).fail(function () {
                        alertErrorToast();
                        //revert to original state
                        $(element).find("i").removeClass("bi-hourglass-split");
                        $(element).find("i").addClass("bi-envelope");
                    });
                }
            });

            toastr.options = {
                "positionClass": "toast-bottom-right",
            }
        });

        function favoriteAddedToast(coin, provider) {
            toastr.success(coin + " from " + capitalize(provider) + " added to favorites!");
        }

        function favoriteRemovedToast(coin, provider) {
            toastr.success(coin + " from " + capitalize(provider) + " removed from favorites!");
        }

        function favoriteErrorToast() {
            toastr.error("Error occurred updating favorites. Please try again.");
        }

        function alertAddedToast(coin, provider) {
            toastr.success("Subscribed to alerts for " + coin + " from " + capitalize(provider));
        }

        function alertRemovedToast(coin, provider) {
            toastr.success("Unsubscribed from alerts for " + coin + " from " + capitalize(provider));
        }

        function alertErrorToast() {
            toastr.error("Error occurred updating alerts. Please try again.");
        }

        function capitalize(word) {
            return word.substr(0,1).toUpperCase()+word.substr(1);
        }
    </script>
@endsection

@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        .coinLogo {
            width: 5rem;
            margin: auto;
            border: 1px solid rgba(0, 0, 0, .125);
            padding: .25rem;
            border-radius: 50%;
        }

        .coin-button {
            color: rgba(121, 121, 121, .8);
            display: inline-block;
            height: 30px;
            line-height: 30px;
            border: 2px solid rgba(121, 121, 121, .5);
            text-align: center;
            width: 30px;
            border-radius: 50%;
            padding-top: 5px;
        }

        @desktop
        .coin-button:hover {
            color: #797979;
            border: 2px solid #797979
        }
        @enddesktop
    </style>
@endsection

@section('content')
    <div>
        <h1 class="text-center">Manage Coin Preferences</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">

                @foreach ($data as $source)
                    <a name="{{$source[0]->source}}_coins"></a>
                    <h4 class="card-title mb-2 mt-1">{{ Str::ucfirst($source[0]->source) }}</h4>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($source as $coin)
                            <div class="col">
                                <div class="card mb-1">
                                    <img src="{{ $coin->image }}" class="card-img-top mt-1 coinLogo" alt="{{ $coin->name }} image">
                                    <div class="card-body" style="text-align: center;">
                                        <p>{{ $coin->name }} | {{ $coin->symbol }}</p>
                                        <div>
                                            <a class="coin-button" data-type="favorite" data-coin="{{ $coin->symbol }}" data-provider="{{ $coin->source }}">
                                                @if ($coin->favorite == 1)
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            </a>
                                            <a class="coin-button" data-type="alert" data-coin="{{ $coin->symbol }}" data-provider="{{ $coin->source }}">
                                                @if ($coin->alert == 1)
                                                    <i class="bi bi-envelope-fill"></i>
                                                @else
                                                    <i class="bi bi-envelope"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @endforeach

                <p class="card-text text-center mt-1">
                    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                </p>
            </div>
        </div>

    </div>
@endsection