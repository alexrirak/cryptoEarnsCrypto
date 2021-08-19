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

        table {
            border-collapse: collapse;
        }

        .loginButton {
            background-color: #6c757d;
            font-size: 18px;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: bold;
            text-decoration: none;
            padding: 14px 20px;
            color: #ffffff;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0px;
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
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                                    <p style="margin: 0px 0px 20px;">Please click the link below to log in to your {{ config('app.name') }} account.</p>
                                    <p style="margin: 0px 0px 20px;">This link will expire in 15 minutes and can only be used once.</p>
                                    <a href="{{$url}}" class="loginButton">
                                        <span>Click to login</span>
                                    </a>

                                    <p style="margin: 20px 0px 0px;">If the button above doesn’t work, paste this link into your web browser:</p>
                                    <p style="margin: 0px 0px 20px;font-size: 0.8rem;max-width: 42rem;"> {{$url}}</p>

                                    <p style="margin: 40px 0px 10px;color:#b3b3b1;">If you did not make this request, you can safely ignore this email.</p>

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
                                    <a href="{{ route('disclaimer') }}" >[Disclaimer]</a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle;">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                    <a href="{{ route('support-us') }}" >[Support Us]</a>
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
