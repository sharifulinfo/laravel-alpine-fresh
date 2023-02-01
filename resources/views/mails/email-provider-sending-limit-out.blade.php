<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SalesMix</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"></head>
<body style="padding:0; margin: 0; background: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; font-style: normal; font-weight: 400; line-height: 1.6; color:#707070">
<table style="margin:auto; padding-top:25px">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="max-width:700px; padding:0px;">
                        <!-- Header -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#ffffff; padding:24px">
                            <tr>
                                <td style="text-align:center;">
                                    <img src="https://app.salesmix.com/backend/images/logo.png" mc:edit="image_1" style="max-width:132px; height: auto;" border="0" alt="logo" />
                                </td>
                            </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: rgba(75, 33, 238, 0.03)">
                                        <tr>
                                            <td style="padding:32px 24px">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr class="">
                                                        <td style="text-align: left; ">
                                                            <div style="font-weight: 600; font-size: 18px">Hello {{$name}},</div>
                                                            <div style="padding: 24px 0 16px 0;">
                                                                <div style="margin-bottom:12px">Thank you for using SalesMix!</div>
                                                                System could not able to send any email today, because email "{{$email_provider}}" email provider sending limit has been out!. But don't worry we will continue sending tomorrow.
                                                                <a href="{{$link}}" style="background: #3f39f3; padding: 8px 24px; border-radius: 3px; color: #fff; margin-top:16px; margin-bottom:24px; text-decoration: none; display: inline-block; "> See details </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left;">
                                                            <div style="font-size: 18px; font-weight:600">
                                                                Thank you!
                                                            </div>
                                                            <div style="font-size: 18px; font-weight:600">
                                                                The SalesMix Team
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table style="padding:24px; background:#ffffff; width:100%">
                            <tr style="text-align:center; display: block; margin-bottom:8px">
                                <td style="margin-left: 16px; margin-right: 16px; display: inline-block;">
                                    <a href="#">
                                        <img src="{{LIVE_URL}}/images/twitter.png" alt="twitter" />
                                    </a>
                                </td>
                                <td style="margin-left: 16px; margin-right: 16px; display: inline-block;">
                                    <a href="#">
                                        <img src="{{LIVE_URL}}/images/facebook.png" alt="facebook" />
                                    </a>
                                </td>
                                <td style="margin-left: 16px; margin-right: 16px; display: inline-block;">
                                    <a href="#">
                                        <img src="{{LIVE_URL}}/images/instagram.png" alt="instagram" />
                                    </a>
                                </td>
                                <td style="margin-left: 16px; margin-right: 16px; display: inline-block;">
                                    <a href="#">
                                        <img src="{{LIVE_URL}}/images/linkedin.png" alt="linkedin" />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>If you’re having trouble clicking the "Get Started Here" button, copy and paste the URL
                                    below into your web browser: <a href="https://salesmix.com/" style="color:#4b21ee; font-weight:bold">https://salesmix.com</a>
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
</html>';
