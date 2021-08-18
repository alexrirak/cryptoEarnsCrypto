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
                                    <h1 style="font-size: 24px; margin: 0;">{{config('app.name')}} Login Verification!</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                                    <p style="margin: 0px 0px 20px;">Hello, to finish logging in please click the link below</p>
                                    <a href="{{$url}}" >
                                        <button>Click to login</button>
                                    </a>

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
