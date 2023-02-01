<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$subject}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body style="padding:0; margin: 0; background: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
    <table style="margin:auto; padding:24px 16px">
        <tr>
            <td align="center" valign="top">
                <table width="880" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width:880px; min-width:880px; padding:0px;">
                            <!-- Header -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="text-align:center;"><img src="https://app.salesmix.com/auth/images/logo.png" mc:edit="image_1" style="max-width:132px; height: auto;" border="0" alt="logo" /></td>
                                </tr>
                                <tr>
                                    <td style="padding: 32px 24px 24px 24px;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="text-align: center; ">
                                                    <div style="font-family: 'Plus Jakarta Sans', sans-serif;;
                                                    font-style: normal;
                                                    font-weight: 400;
                                                    font-size: 34px;
                                                    line-height: 52px;
                                                    text-align: center;
                                                    color: #000000;">Reset Password</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- Main Body  -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: rgba(75, 33, 238, 0.03);  padding: 48px 50px; text-align: center; margin-bottom: 24px;">
                                <tr>
                                    <td>
                                        <img src="https://app.salesmix.com/backend/images/lock.png" mc:edit="image_1" style="max-width:132px; height: auto;" border="0" alt="Lock Icon" />
                                        <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.1" width="96" height="96" rx="12" fill="#4B21EE"/>
                                            <path d="M47.5 65C50.5376 65 53 62.7614 53 60C53 57.2386 50.5376 55 47.5 55C44.4624 55 42 57.2386 42 60C42 62.7614 44.4624 65 47.5 65Z" fill="#4B21EE"/>
                                            <path d="M67.282 40.7195V36.782C67.282 28.277 65.2345 17 47.5 17C29.7655 17 27.718 28.277 27.718 36.782V40.7195C18.898 41.822 16 46.295 16 57.2885V63.1475C16 76.0625 19.9375 80 32.8525 80H62.1475C75.0625 80 79 76.0625 79 63.1475V57.2885C79 46.295 76.102 41.822 67.282 40.7195ZM47.5 69.731C42.2395 69.731 37.987 65.447 37.987 60.218C37.987 54.9575 42.271 50.705 47.5 50.705C52.729 50.705 57.013 54.989 57.013 60.218C57.013 65.4785 52.7605 69.731 47.5 69.731ZM32.8525 40.436C32.6005 40.436 32.38 40.436 32.128 40.436V36.782C32.128 27.5525 34.7425 21.41 47.5 21.41C60.2575 21.41 62.872 27.5525 62.872 36.782V40.4675C62.62 40.4675 62.3995 40.4675 62.1475 40.4675H32.8525V40.436Z" fill="#4B21EE"/>
                                        </svg>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Plus Jakarta Sans', sans-serif;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 20px;
                                    line-height: 32px;
                                    text-align: center;
                                    color: #5E5E5E;
                                    max-width: 642px;
                                    display: block;
                                    margin: auto;
                                    padding: 24px 0;
                                    "><span style=" font-weight: 700;">Hello {{$name}}, </span> SalesMix recently received a request for a forgotten password. To change your SalesMix password, please click on below link</td>
                                </tr>
                                <tr>
                                    <td>
                                        @foreach($code_arr as $c)
                                            <input value="{{$c}}" style="border:1px solid #e3e3e3; margin:0 4px; font-size: 18px; outline: none; text-align: center; padding: 4px; border-radius: 4px; width: 24px; height: 24px;">
                                        @endforeach
{{--                                        <input value="9" style="border:1px solid #e3e3e3; margin:0 4px; font-size: 18px; outline: none; text-align: center; padding: 4px; border-radius: 4px; width: 24px; height: 24px;">--}}
{{--                                        <input value="3" style="border:1px solid #e3e3e3; margin:0 4px; font-size: 18px; outline: none; text-align: center; padding: 4px; border-radius: 4px; width: 24px; height: 24px;">--}}
{{--                                        <input value="7" style="border:1px solid #e3e3e3; margin:0 4px; font-size: 18px; outline: none; text-align: center; padding: 4px; border-radius: 4px; width: 24px; height: 24px;">--}}
{{--                                        <input value="1" style="border:1px solid #e3e3e3; margin:0 4px; font-size: 18px; outline: none; text-align: center; padding: 4px; border-radius: 4px; width: 24px; height: 24px;">--}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Barlow', sans-serif;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 20px;
                                    line-height: 32px;
                                    text-align: center;
                                    color: #5E5E5E; padding: 24px 0 16px 0;"> If you did not request this change, you do not need to do anything.</td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Barlow', sans-serif;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 20px;
                                    line-height: 32px;
                                    text-align: center;
                                    color: #5E5E5E;
                                    "> Thanks,</td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Barlow', sans-serif;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 20px;
                                    line-height: 32px;
                                    text-align: center;
                                    color: #5E5E5E;
                                    ">Team SalesMix</td>
                                </tr>
                            </table>
                            <!-- Footer -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>
                                    <td style="
                                    font-family: 'Plus Jakarta Sans', sans-serif;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 16px;
                                    line-height: 20px;
                                    text-align: center;
                                    color: #000000;
                                    display: block;
                                    margin-top: 48px;
                                    margin-bottom: 16px;
                                    ">Copyright © 2022</td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Plus Jakarta Sans', sans-serif;
                                    font-style: normal;
                                    font-weight: 700;
                                    font-size: 16px;
                                    line-height: 20px;
                                    text-align: center;
                                    color: #000000;
                                    ">SalesMIx</td>
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
