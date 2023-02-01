<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="polyuno" content="{{ csrf_token() }}"/>
        <title>
            @if(isset($title) & !empty($title))
                {{ $title }}
            @else
                @yield('title')
            @endif
        </title>
        <link rel="icon" type="image/png" href="{{url('backend')}}/images/favicon.svg"/>
        <!-- Bootstrap CSS -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet">
        <link href="{{asset('vendors/sweetalert/sweetalert.css')}}" rel="stylesheet">
        <link href="{{asset('vendors/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
        <link href="{{url('backend')}}/css/style.css" rel="stylesheet">
        <link href="{{url('backend')}}/css/sequence.css" rel="stylesheet">
        <link href="{{url('backend')}}/css/prospect.css" rel="stylesheet">
        <link href="{{url('backend')}}/css/email.css" rel="stylesheet">
        <link href="{{url('backend')}}/css/inbox.css" rel="stylesheet">
        <link href="{{url('backend')}}/css/admin.css" rel="stylesheet">
        <link href="{{url('backend')}}/css/responsive.css" rel="stylesheet">
        @stack('css')
    </head>
    <body x-data="root" x-init="siteInit">
        <div class="loading-page custom-loader" style="display: none">
            <div class="text-center pb-3">
                <h4 class="loading-page-title title-lg text-white pb-3 l-spacing-lg fw-normal"></h4>
                <h3 class="loading-page-count">0%</h3>
                <div class="progress bg-light" style="height: 8px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                </div>
            </div>
        </div>
        <!-- Page Header -->
        @include('layouts.includes.header')
        <!-- Page aside -->
        @if(auth()->user()->user_type === 'admin')
            @include('layouts.includes.admin-sidebar')
        @else
            @include('layouts.includes.sidebar')
        @endif
        <!-- Page Main content -->
        <div class="main">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@1.x.x/dist/cdn.min.js" defer></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
        <script src="{{asset('vendors/ladda/spin.min.js')}}"></script>
        <script src="{{asset('vendors/ladda/ladda.min.js')}}"></script>
        <script src="{{asset('vendors/ladda/ladda.jquery.min.js')}}"></script>
        <script src="{{url('vendors/tippy/popper.min.js')}}"></script>
        <script src="{{url('vendors/tippy/tippy-bundle.umd.min.js')}}"></script>
        <script src="{{url('vendors/main/app.js')}}"></script>
        <script src="{{url('vendors/main/analytics.js')}}"></script>
        <script src="{{url('vendors/main/alpine-fn.js')}}"></script>
        <script defer src="{{url('backend')}}/js/main.js"></script>
        <script>
            $url = "{{url('/')}}";
            $(document).ready(() => {
                setInterval(() => {
                    $('.placeholder-content').each(function () {
                        // let $h = globalJs.getRandomArbitrary(30, 50);
                        let $w = root.getRandomArbitrary(30, 100);
                        $(this).css('width', $w + '%');
                    });
                }, 1500);
            });

            @if(session()->has('LoggedInUserId'))
                function backToAdmin(){
                    makeAjaxPost(this.meta, '{{route("spyUserLogout")}}', 'loggedInOut').done(res => {
                        if(res.success){
                            setTimeout(()=>{
                                window.location.href = "{{route('users')}}";
                            },500);
                        }else{
                            swalError(res.msg);
                        }
                    })
                }
            @endif

        </script>
        @stack('js')
    </body>
</html>
