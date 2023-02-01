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
            @include('users.modals.global-modal')
        </div>

        @if(session()->has('LoggedInUserId'))
            <div class="loggedInOut position-fixed end-4 bottom-4 cursor-pointer d-flex bg-warning p-2 rounded-2 text-dark" onclick="backToAdmin()">
                <svg width="16" height="16" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.32678 13H9.24011C6.28018 13 4.85355 11.8924 4.60689 9.41139C4.58023 9.1519 4.78022 8.91772 5.06021 8.8924C5.33354 8.86709 5.5802 9.06329 5.60687 9.32278C5.8002 11.3101 6.78684 12.0506 9.24678 12.0506H9.33344C12.0467 12.0506 13.0067 11.1392 13.0067 8.56329V4.43671C13.0067 1.86076 12.0467 0.949367 9.33344 0.949367H9.24678C6.77351 0.949367 5.78686 1.70253 5.60687 3.72785C5.57353 3.98734 5.34687 4.18354 5.06021 4.15823C4.78022 4.13924 4.58023 3.90506 4.60022 3.64557C4.82689 1.12658 6.26019 0 9.24011 0H9.32678C12.6 0 14 1.32911 14 4.43671V8.56329C14 11.6709 12.6 13 9.32678 13Z" fill="currentColor"></path>
                    <path d="M9.08645 6.9747H0.499988C0.226661 6.9747 0 6.75951 0 6.50001C0 6.24052 0.226661 6.02533 0.499988 6.02533H9.08645C9.35978 6.02533 9.58644 6.24052 9.58644 6.50001C9.58644 6.75951 9.36644 6.9747 9.08645 6.9747Z" fill="currentColor"></path>
                    <path d="M7.59971 9.09501C7.47305 9.09501 7.34639 9.0507 7.24639 8.95576C7.05306 8.77222 7.05306 8.46842 7.24639 8.28488L9.12634 6.50007L7.24639 4.71526C7.05306 4.53171 7.05306 4.22792 7.24639 4.04437C7.43972 3.86083 7.75971 3.86083 7.95304 4.04437L10.1863 6.16463C10.3796 6.34817 10.3796 6.65197 10.1863 6.83551L7.95304 8.95576C7.85304 9.0507 7.72638 9.09501 7.59971 9.09501Z" fill="currentColor"></path>
                </svg>
            </div>
        @endif

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
        @include('layouts.includes.websocket')
        @stack('js')
    </body>
</html>
