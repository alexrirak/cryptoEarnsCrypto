@extends('template')

@section('title', 'Manage Subscriptions')

@section('styles')
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
        <h1 class="text-center">Manage Subscriptions</h1>

        <div class="card mx-auto mt-3 content-card">
            <div class="card-body">

                @foreach ($data as $source)
                    <a name="{{$source[0]->source}}_coins"></a>
                    <h4 class="card-title mb-2">{{ Str::ucfirst($source[0]->source) }}</h4>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($source as $coin)
                            <div class="col">
                                <div class="card">
                                    <img src="{{ $coin->image }}" class="card-img-top mt-1 coinLogo" alt="{{ $coin->name }} image">
                                    <div class="card-body" style="text-align: center;">
                                        <p>{{ $coin->name }} | {{ $coin->symbol }}</p>
                                        <div>
                                            <a class="coin-button">
                                                @if ($coin->favorite == 1)
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            </a>
                                            <a class="coin-button">
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

                <p class="card-text text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                </p>
            </div>
        </div>

    </div>
@endsection