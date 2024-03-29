<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style type="text/css">
        a[x-apple-data-detectors] {
            color: inherit !important;
        }

        .coinLogo {
            width: 2em;
            height: 2em;
            margin: auto;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-success {
            background-color: #198754 !important;
        }

        .badge {
            display: inline-block;
            padding: .35em .65em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        #disclaimer a {
            color: #ffffff;
        }

        #disclaimer td {
            padding-bottom: 5px;
            color: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 15px;
            text-align: center;
        }

        #rateTable table, #rateTable th, #rateTable td {
            border: 1px black solid;
        }

        #rateTable th, #rateTable tr:nth-child(even) {
            background-color: #eee;
        }

        table {
            border-collapse: collapse;
        }

        .history_button {
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
            border-width: 1px;
        }
    </style>

</head>

<body style="margin: 0; padding: 0;">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 20px 0 30px 0;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #cccccc;min-width: 480px;border-radius: 20px;overflow: hidden;">
                <tr>
                    <td align="center" style="background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f7a449), to(#f7a74c));background-color: #f7a449;padding: 8px;">
                        <h1 style="text-shadow: 0 1px 0 #ccc,
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 0 5px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);color:white;font: bold 40px/1 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                            {{ config('app.name') }}</h1>
                    </td>
                </tr>
                <tr style="border-width: 0px 3px;border-color: #f7a449;border-style: solid;">
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                               style="border-collapse: collapse;">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif;">
                                    <h1 style="font-size: 24px; margin: 0;">{{ Str::ucfirst($provider->name) }} Rate Change Notification!</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                                    <p style="margin: 0px 0px 20px;">You are receiving this email because you signed up on {{ config('app.name') }}
                                        for alerts on {{ Str::ucfirst($provider->name) }} rate changes. Here are your alerts:
                                    </p>
                                    <table style="width: 100%;text-align: center;" id="rateTable">
                                        <thead>
                                        <tr>
                                            <th>Coin</th>
                                            <th>Ticker</th>
                                            <th>Current Rate</th>
                                            <th>Prior Rate</th>
                                            <th>Change Amount</th>
                                            <th>Change Percent</th>
                                            <th>Change Date</th>
                                            <th>History</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($rateChanges as $rate)
                                            <tr>
                                                <td>
                                                    <img class="coinLogo" src="{{ $rate->image }}" alt="{{ $rate->name }}" title="{{ $rate->name }}" />
                                                </td>
                                                <td>
                                                    {{ $rate->symbol }}
                                                </td>
                                                <td>
                                                    {{ sprintf("%0.2f %%", (float) $rate->latest_rate * 100)  }}
                                                </td>
                                                <td>
                                                    {{ sprintf("%0.2f %%", (float) $rate->prior_rate * 100)  }}
                                                </td>
                                                <td>
                                                    <span class="badge @if ((float) $rate->latest_rate - (float) $rate->prior_rate  < 0) bg-danger @else bg-success @endif">{{ sprintf("%0.2f", ((float) $rate->latest_rate - (float) $rate->prior_rate) * 100) }}</span>
                                                </td>
                                                <td>
                                                    @if ($rate->prior_rate  > 0)
                                                        <span class="badge @if ((float) $rate->latest_rate - (float) $rate->prior_rate  < 0) bg-danger @else bg-success @endif">{{ sprintf("%0.2f %%", (((float) $rate->latest_rate - (float) $rate->prior_rate) / (float) $rate->prior_rate) * 100) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ date('Y-m-d',strtotime($rate->latest_date)) }}
                                                </td>
                                                <td>
                                                    @if ($rate->chartAvailable == 1)
                                                        <a href="{{ route('history-by-provider-and-coin', ["provider"=>$provider->name, "coin"=>$rate->symbol]) }}">
                                                            <button type="button" class="history_button">
                                                                <img src="{{ route('home') }}/img/graph-up-arrow.png" />
                                                            </button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#f7a449" style="padding: 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;" id="disclaimer">
                            <tr>
                                <td style="padding-bottom: 10px;">
                                    <a href="{{ route('unsubscribe', ["emailId"=>bin2hex($user->email)]) }}" >[Unsubscribe]</a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle;">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                    <a href="{{ route('disclaimer') }}" >[Disclaimer]</a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle;">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                    <a href="{{ route('support-us') }}" >[Support Us]</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Visit <a href="{{ route('home') }}" >{{ config('app.name') }}</a> for the latest information and to update your preferences. If you no longer wish to receive alerts, <a href="{{ route('unsubscribe', ["emailId"=>bin2hex($user->email)]) }}" >unsubscribe here</a>.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ config('app.name') }} is not affiliated with any of the tracked providers. All logos property of their respective owners.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>

</html>
