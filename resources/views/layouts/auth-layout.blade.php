<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{url('auth')}}/images/favicon.svg" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="{{asset('vendors/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendors/intl-tel-Input/intlTelInput.css')}}">
    <link href="{{url('auth')}}/css/style.css" rel="stylesheet">
    <style>
        .iti.iti--allow-dropdown.iti--separate-dial-code {
            width: 100%;
        }
    </style>
    @stack('css')
    <meta name="polyuno" content="{{ csrf_token() }}"/>
    <title>{{$title ?? 'SalesMix'}}</title>
</head>

<body>

    <div class="row gx-0">
        <div class="col-xl-2 d-none d-xl-block">
            <div class="brand-logo">
                <img src="{{url('auth')}}/images/logo.png" alt="logo" class="img-fluid">
            </div>
        </div>
        @yield('content')
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="{{url('vendors/btnLoader/bootstrap-loadingbtn.js')}}"></script>
    <script src='{{url("vendors/intl-tel-Input/intlTelInput.js")}}'></script>
    <script src="{{asset('vendors/ladda/spin.min.js')}}"></script>
    <script src="{{asset('vendors/ladda/ladda.min.js')}}"></script>
    <script src="{{asset('vendors/ladda/ladda.jquery.min.js')}}"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script defer src="{{url('vendors/main/app.js')}}"></script>

    @stack('js')

    <script>
        $('.auth-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 1000,
        autoplayHoverPause: true,
        slideTransition: 'linear',
    })

    $(".toggle-password").click(function () {
        $(this).toggleClass("field-icon");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
        console.log(123)
    });


    </script>
</body>

</html>
