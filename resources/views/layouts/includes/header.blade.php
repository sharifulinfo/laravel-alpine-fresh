<header class="theme-header-template">
    <div class="header-template-left">
        {{-- theme Logo --}}
        <div class="theme-logo-wrapper">
            <div class="d-flex justify-content-between position-relative">
                <a href="{{url('dashboard')}}" class="navbar-brand border-end">
                    <img src="{{url('backend')}}/images/logo.png" alt="logo">
                </a>
                <div id="toggler" class="side-nav-arror-wrap" data-toggle="sidenav" data-target="#full-screen-example">
                    <img src="http://localhost/roboimage/public/img/nav-arrow.png" alt="">
                </div>
            </div>
        </div>
        <div class="three-dots d-none" id="toggler">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </div>
    </div>

    <div class="header-template-right">
        <div class="position-relative theme-search-box-wrap header-search-box d-xxl-block d-none">
            <span class="position-absolute top-50 start-3 translate-middle-y d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <!--  trial remainng -->
        <!-- user notifications -->
        <div class="user-notification-wrap ms-4 ps-3">
            <div class="dropdown">
                <div @click="loadNotifications" class="dropdown-toggle notification-dropdown-toggle pe-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg width="23" height="28" viewBox="0 0 19 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.5625 14.988L17.3274 12.996C17.068 12.552 16.8334 11.712 16.8334 11.22V8.18401C16.8334 5.36401 15.129 2.928 12.6711 1.788C12.0289 0.684001 10.8432 0 9.48465 0C8.13841 0 6.92804 0.708001 6.2858 1.824C3.8774 2.988 2.21004 5.40001 2.21004 8.18401V11.22C2.21004 11.712 1.97538 12.552 1.71601 12.984L0.468584 14.988C-0.0254474 15.792 -0.136605 16.68 0.172165 17.496C0.468583 18.3 1.17258 18.924 2.08653 19.224C4.48259 20.016 7.00214 20.4 9.5217 20.4C12.0413 20.4 14.5608 20.016 16.9569 19.236C17.8214 18.96 18.4884 18.324 18.8095 17.496C19.1306 16.668 19.0441 15.756 18.5625 14.988Z" fill="#303030"/>
                        <path d="M12.9923 21.6121C12.4736 23.0041 11.1027 24.0001 9.49708 24.0001C8.52137 24.0001 7.55801 23.6161 6.87871 22.9321C6.48349 22.5721 6.18707 22.0921 6.01416 21.6001C6.17472 21.6241 6.33528 21.6361 6.50819 21.6601C6.79226 21.6961 7.08868 21.7321 7.3851 21.7561C8.08909 21.8161 8.80544 21.8521 9.52178 21.8521C10.2258 21.8521 10.9298 21.8161 11.6214 21.7561C11.8808 21.7321 12.1401 21.7201 12.3872 21.6841C12.5848 21.6601 12.7824 21.6361 12.9923 21.6121Z" fill="#303030"/>
                    </svg>
                    <template x-if="notificationCount > 0">
                        <p x-text="notificationCount" class="notification-count"></p>
                    </template>
                </div>

                <div class="dropdown-menu notification-dropdown-menu mt-4" aria-labelledby="dropdownMenuButton1">
                    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                        <h6 class="title-sm">Notifications</h6>
{{--                        <a href="#" class="description text-decoration-underline text-body">Mark all as read</a>--}}
                    </div>
                    <ul class="notification-items scrollbar-primary">
                        <li class="py-3 px-4 notification-item" x-show="notifyLoading">
                            <div x-html="getPlaceHolder(notifyLoading,6)" class="mb-3"></div>
                        </li>
                        <template x-if="!notifyLoading">
                            <div>
                                <template x-if="notifications.length > 0">
                                    <template x-for="(getN,i) in notifications">
                                        <li>
                                            <a class="dropdown-item border-bottom border-light text-wrap align-items-start" :href="getN.link">
                                                <div class="notification-item-img position-relative">
                                                    <template x-if="getN.type==='Profile'">
                                                        <div class="notification-item-icon">
                                                            <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7.09482 7.80488C9.25008 7.80488 10.9973 6.0577 10.9973 3.90244C10.9973 1.74718 9.25008 0 7.09482 0C4.93956 0 3.19238 1.74718 3.19238 3.90244C3.19238 6.0577 4.93956 7.80488 7.09482 7.80488Z" fill="#707070" />
                                                                <path d="M7.09463 9.75586C3.18439 9.75586 0 12.3783 0 15.6095C0 15.8281 0.171707 15.9998 0.390244 15.9998H13.799C14.0176 15.9998 14.1893 15.8281 14.1893 15.6095C14.1893 12.3783 11.0049 9.75586 7.09463 9.75586Z" fill="#707070" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                    <template x-if="getN.type==='Subscriptions'">
                                                        <div class="notification-item-icon">
                                                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.1429 0H4.04762C1.61905 0 0 1.17692 0 3.92308V10.1686C0 11.9654 1.49762 13.4169 3.35143 13.4169H8.41904C8.88857 13.4169 9.29333 13.0325 9.24476 12.5774C9.13143 11.3769 9.53619 10.0823 10.6371 9.03877C11.0905 8.60723 11.649 8.27769 12.2562 8.08938C13.2681 7.77554 14.2476 7.81477 15.1138 8.10507C15.64 8.27769 16.1905 7.90892 16.1905 7.36754V3.92308C16.1905 1.17692 14.5714 0 12.1429 0ZM12.5233 4.386L9.98952 6.34754C9.45524 6.76338 8.77524 6.96738 8.09524 6.96738C7.41524 6.96738 6.72714 6.76338 6.20095 6.34754L3.66714 4.386C3.40809 4.182 3.36762 3.81323 3.57 3.55431C3.78047 3.30323 4.16095 3.25615 4.42 3.46015L6.95381 5.42169C7.56905 5.90031 8.61333 5.90031 9.22857 5.42169L11.7624 3.46015C12.0214 3.25615 12.41 3.29538 12.6124 3.55431C12.8229 3.81323 12.7824 4.182 12.5233 4.386Z" fill="#707070" />
                                                                <path d="M13.7618 9.41602C11.9727 9.41602 10.5237 10.8205 10.5237 12.5545C10.5237 13.1429 10.6937 13.7 10.9932 14.1708C11.5518 15.0809 12.5799 15.6929 13.7618 15.6929C14.9437 15.6929 15.9718 15.0809 16.5303 14.1708C16.8299 13.7 16.9999 13.1429 16.9999 12.5545C16.9999 10.8205 15.5508 9.41602 13.7618 9.41602ZM15.3565 12.2956L13.6323 13.8412C13.5189 13.9432 13.3651 13.9982 13.2194 13.9982C13.0656 13.9982 12.9118 13.9432 12.7903 13.8256L11.9889 13.0488C11.7542 12.8212 11.7542 12.4446 11.9889 12.2171C12.2237 11.9896 12.6123 11.9896 12.847 12.2171L13.2356 12.5937L14.5308 11.4325C14.7737 11.2128 15.1623 11.2285 15.3889 11.4639C15.6156 11.6992 15.5994 12.0759 15.3565 12.2956Z" fill="#707070" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                    <template x-if="getN.type==='Campaign'">
                                                        <div class="notification-item-icon">
                                                            <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M14.2168 11.0976L11.6608 7.83165C11.5898 7.76065 11.5898 7.61865 11.5898 7.54765C11.5898 7.47665 11.6608 7.33465 11.7318 7.26365C11.8028 7.19265 11.8738 7.19265 11.9448 7.19265C12.0868 7.19265 12.1578 7.26365 12.2288 7.33465L15.2818 11.2396C15.4238 11.4526 15.6368 11.5946 15.9208 11.5946C15.9918 11.5946 15.9918 11.5946 16.0628 11.5946C16.2758 11.5946 16.4888 11.5236 16.6308 11.3816C17.0568 11.0266 17.1278 10.4586 16.7728 10.0326L9.45978 0.660663C9.24678 0.447664 9.03378 0.376664 8.82078 0.305664C8.74978 0.305664 8.74978 0.305664 8.67878 0.305664C8.46578 0.305664 8.25278 0.376664 8.11078 0.518664C7.89778 0.660663 7.75578 0.873663 7.75578 1.15766C7.75578 1.44166 7.82678 1.65466 7.96878 1.86766L11.0218 5.84365C11.0928 5.91465 11.0928 6.05665 11.0928 6.12765C11.0928 6.19865 11.0218 6.34065 10.9508 6.41165C10.8798 6.48265 10.8088 6.48265 10.7378 6.48265C10.5958 6.48265 10.5248 6.41165 10.4538 6.34065L7.82678 3.00366L4.56079 9.81964L6.83279 12.7306L14.2168 11.0976Z" fill="#707070" />
                                                                <path d="M0.37207 13.5822L2.14707 15.8542L3.28306 15.0022L1.50807 12.6592L0.37207 13.5822Z" fill="#707070" />
                                                                <path d="M6.97531 13.9379L3.35432 9.32295C3.28332 9.25195 3.28332 9.25195 3.21232 9.25195C3.14132 9.25195 3.07032 9.25195 2.99932 9.32295L1.22432 10.7429C1.15332 10.8139 1.15332 10.8849 1.15332 10.8849C1.15332 10.9559 1.15332 11.0269 1.22432 11.0979L4.13531 14.8609L4.77431 15.7129C4.84531 15.7839 4.91631 15.7839 4.98731 15.7839C5.05831 15.7839 5.12931 15.7839 5.12931 15.7129L6.90431 14.2929C7.04631 14.2219 7.04631 14.0799 6.97531 13.9379Z" fill="#707070" />
                                                                <path d="M7.04591 15.1455L5.90991 16.0685L7.96891 18.6955L9.1049 17.7725L7.04591 15.1455Z" fill="#707070" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                    <template x-if="getN.type==='Members'">
                                                        <div class="notification-item-icon">
                                                            <svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M13.6364 5.57143C15.1455 5.57143 16.3545 4.32714 16.3545 2.78571C16.3545 1.24429 15.1455 0 13.6364 0C12.1273 0 10.9091 1.24429 10.9091 2.78571C10.9091 4.32714 12.1273 5.57143 13.6364 5.57143ZM6.36364 5.57143C7.87273 5.57143 9.08182 4.32714 9.08182 2.78571C9.08182 1.24429 7.87273 0 6.36364 0C4.85455 0 3.63636 1.24429 3.63636 2.78571C3.63636 4.32714 4.85455 5.57143 6.36364 5.57143ZM6.36364 7.42857C4.24545 7.42857 0 8.515 0 10.6786V13H12.7273V10.6786C12.7273 8.515 8.48182 7.42857 6.36364 7.42857ZM13.6364 7.42857C13.3727 7.42857 13.0727 7.44714 12.7545 7.475C13.8091 8.255 14.5455 9.30429 14.5455 10.6786V13H20V10.6786C20 8.515 15.7545 7.42857 13.6364 7.42857Z" fill="#707070" />
                                                            </svg>
                                                        </div>
                                                    </template>

                                                    <template x-if="getN.type==='Email'">
                                                        <div class="notification-item-icon">
                                                            <svg width="20" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M11.25 0H3.75C1.5 0 0 1.14706 0 3.82353V9.17647C0 11.8529 1.5 13 3.75 13H11.25C13.5 13 15 11.8529 15 9.17647V3.82353C15 1.14706 13.5 0 11.25 0ZM11.6025 4.65706L9.255 6.56882C8.76 6.97412 8.13 7.17294 7.5 7.17294C6.87 7.17294 6.2325 6.97412 5.745 6.56882L3.3975 4.65706C3.1575 4.45824 3.12 4.09118 3.3075 3.84647C3.5025 3.60176 3.855 3.55588 4.095 3.75471L6.4425 5.66647C7.0125 6.13294 7.98 6.13294 8.55 5.66647L10.8975 3.75471C11.1375 3.55588 11.4975 3.59412 11.685 3.84647C11.88 4.09118 11.8425 4.45824 11.6025 4.65706Z" fill="#707070"></path>
                                                            </svg>
                                                        </div>
                                                    </template>

{{--                                                    <img class="" src="{{url('backend')}}/images/notification-item.svg" alt="notification img">--}}
                                                </div>
                                                <div class="notification-item-details">
                                                    <h6 class="title-sm" x-html="getN.body"></h6>
                                                    <div class="pt-1 d-flex align-items-center gap-2">
                                                        <div>
                                                            <span class="description-sm" x-text="getN.format_time"></span>.
                                                        </div>
                                                        <span class="description-sm" x-text="getN.type"></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </template>
                                </template>
                                <template x-if="notifications.length == 0">
                                    <div class="notifications-empty p-4 text-center">
                                        <svg width="70" height="70" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" xml:space="preserve">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: none;
                                                    stroke: #707070;
                                                    stroke-width: 14;
                                                    stroke-linecap: round;
                                                    stroke-linejoin: round;
                                                    stroke-miterlimit: 10;
                                                }
                                            </style>
                                            <path class="st0" d="M105,254c-9.9,6.4-33.8,21.4-43.7,27.8c-1.4,0.9-2.7,1.9-4.6,3.2c103.3,58.3,206.1,116.2,309.3,174.4  c0.4-6.1,0.8-11.4,1.1-16.7c1.7-28.2,3.3-56.3,5.2-84.5c0.2-3.2,1.3-6.6,2.9-9.3c20.3-34.6,40.8-69.2,61.2-103.7  c16.2-27.4,22.4-56.8,16.3-88.2c-4.6-23.8-12.8-41.3-27.9-58" />
                                            <path class="st0" d="M407.3,81.4c-0.3-0.2-0.5-0.4-0.8-0.6" />
                                            <path class="st0" d="M387,68.3c-34.9-18.6-71.6-20.6-109.3-6.6c-29.9,11.1-51.9,31.5-67.8,59c-2,3.5-4.1,7-6.1,10.5" />
                                            <path class="st0" d="M190.5,153.7c-13.5,22.9-27.1,45.7-40.7,68.5c-1.5,2.5-3.7,4.8-6.2,6.4c-11.6,7.5-23.2,15-34.7,22.5" />
                                            <path class="st0" d="M155.5,427.1c0.5,0.7,1.1,1.4,1.6,2.1" />
                                            <path class="st0" d="M176.4,443.6c21.8,8.8,48.5,0.7,60.8-20.2c-28.2-15.9-56.1-31.6-83.9-47.3c-6.1,9.3-7.9,20.5-6,31.2" />
                                        </svg>
                                        <h3 class="color-707070 fs-4 mt-3">No available notifications</h3>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
        <!-- user profile -->
        <div class="user-profile-wrap ms-4 ps-3">
            <div class="dropdown">
                <div class="dropdown-toggle user-dropdown-toggle end-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
{{--                    <img class="user-profile-img" src="{{ url(auth()->user()->profile_pic) }}" alt="userlogo">--}}
                    <p class="user-profile-name ms-2 me-xxl-3 d-none d-md-block">{{auth()->user()->name}}</p>
                </div>
                <ul class="dropdown-menu mt-3 pt-3 pb-2" aria-labelledby="dropdownMenuButton1">
                    <li class="px-3 border-bottom pb-2 mb-2 cursor-pointer" data-bs-toggle="modal" data-bs-target="#createWorkspace">
                        <p class="description-sm pb-2" x-text="Object.keys(activeWorkspace).length > 0 ? shortStr(activeWorkspace.name,15):'Loading...'"></p>
                        <p class="description-sm text-body pb-1"><span x-text="Object.keys(activeWorkspace).length > 0 ? activeWorkspace.members : 0 "></span> member(s)</p>
                    </li>
                    <li><a class="dropdown-item user-dropdown-item" href="#">
                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.9999 6.34146C7.82262 6.34146 9.30023 4.92188 9.30023 3.17073C9.30023 1.41958 7.82262 0 5.9999 0C4.17718 0 2.69957 1.41958 2.69957 3.17073C2.69957 4.92188 4.17718 6.34146 5.9999 6.34146Z" fill="currentColor"/>
                                <path d="M6 7.92683C2.69307 7.92683 0 10.0576 0 12.6829C0 12.8605 0.145215 13 0.330033 13H11.67C11.8548 13 12 12.8605 12 12.6829C12 10.0576 9.30693 7.92683 6 7.92683Z" fill="currentColor"/>
                            </svg>
                            <span class="ms-2">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item user-dropdown-item" href="{{url('settings?tab=workspace')}}">
                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.9565 2.5025L7.03357 0.273C6.39296 -0.091 5.60044 -0.091 4.95322 0.273L1.03687 2.5025C0.396257 2.8665 0 3.5425 0 4.277V8.723C0 9.451 0.396257 10.127 1.03687 10.4975L4.95982 12.727C5.60044 13.091 6.39296 13.091 7.04018 12.727L10.9631 10.4975C11.6037 10.1335 12 9.4575 12 8.723V4.277C11.9934 3.5425 11.5971 2.873 10.9565 2.5025ZM5.9967 3.471C6.84865 3.471 7.5355 4.147 7.5355 4.9855C7.5355 5.824 6.84865 6.5 5.9967 6.5C5.14474 6.5 4.4579 5.824 4.4579 4.9855C4.4579 4.1535 5.14474 3.471 5.9967 3.471ZM7.76665 9.529H4.22675C3.6918 9.529 3.3814 8.944 3.67859 8.5085C4.12768 7.852 4.99945 7.41 5.9967 7.41C6.99395 7.41 7.86571 7.852 8.31481 8.5085C8.612 8.9375 8.29499 9.529 7.76665 9.529Z" fill="currentColor"/>
                                </svg>
                            <span class="ms-2">Workspace</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item user-dropdown-item" href="{{url('logout')}}">
                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.32678 13H9.24011C6.28018 13 4.85355 11.8924 4.60689 9.41139C4.58023 9.1519 4.78022 8.91772 5.06021 8.8924C5.33354 8.86709 5.5802 9.06329 5.60687 9.32278C5.8002 11.3101 6.78684 12.0506 9.24678 12.0506H9.33344C12.0467 12.0506 13.0067 11.1392 13.0067 8.56329V4.43671C13.0067 1.86076 12.0467 0.949367 9.33344 0.949367H9.24678C6.77351 0.949367 5.78686 1.70253 5.60687 3.72785C5.57353 3.98734 5.34687 4.18354 5.06021 4.15823C4.78022 4.13924 4.58023 3.90506 4.60022 3.64557C4.82689 1.12658 6.26019 0 9.24011 0H9.32678C12.6 0 14 1.32911 14 4.43671V8.56329C14 11.6709 12.6 13 9.32678 13Z" fill="currentColor"/>
                                <path d="M9.08645 6.9747H0.499988C0.226661 6.9747 0 6.75951 0 6.50001C0 6.24052 0.226661 6.02533 0.499988 6.02533H9.08645C9.35978 6.02533 9.58644 6.24052 9.58644 6.50001C9.58644 6.75951 9.36644 6.9747 9.08645 6.9747Z" fill="currentColor"/>
                                <path d="M7.59971 9.09501C7.47305 9.09501 7.34639 9.0507 7.24639 8.95576C7.05306 8.77222 7.05306 8.46842 7.24639 8.28488L9.12634 6.50007L7.24639 4.71526C7.05306 4.53171 7.05306 4.22792 7.24639 4.04437C7.43972 3.86083 7.75971 3.86083 7.95304 4.04437L10.1863 6.16463C10.3796 6.34817 10.3796 6.65197 10.1863 6.83551L7.95304 8.95576C7.85304 9.0507 7.72638 9.09501 7.59971 9.09501Z" fill="currentColor"/>
                            </svg>
                            <span class="ms-2">Log out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
