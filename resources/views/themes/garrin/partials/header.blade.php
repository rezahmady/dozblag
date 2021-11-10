<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <livewire:partials.custom :view="'theme::partials.logo'" />
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="{{ route('home') }}" class="menu-logo">
                    <livewire:partials.custom :view="'theme::partials.logo'" />
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <livewire:widgets.menu :widget="widget('main_menu')" :view="'theme::widgets.menu.main_menu'" />
        </div>
        <ul class="nav header-navbar-rht">
            <li class="nav-item hidden-mobile chat-icon">
                <button type="button" x-on:click.privent="show_search()" class="button button-chat kt-modal-button kt-login-button" ><i class="la la-search"></i></button>
            </li>
            @auth
            <li class="c-header__btn dropdown nav-item">
                <a class="c-header__btn-login dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="la la-user header-user-icon"></i>
                    <div class="login-text"> <i class="la la-angle-down"></i></div>
                </a>
                <div class="c-header__profile-dropdown js-dropdown-menu dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 55px !important; left: 20px; transform: translate3d(0px, 52px, 0px);">
                    <div class="c-header__profile-dropdown-account-container">
                        <div class="c-header__profile-dropdown-user">
                            <div class="c-header__profile-dropdown-user-img">
                                <img style="border-radius:20px;" src="{{auth()->user()->getProfile()}}">
                            </div>

                            <div class="c-header__profile-dropdown-user-info">
                                <p class="c-header__profile-dropdown-user-name">{{auth()->user()->name}}</p>
                                    <span class="c-header__profile-dropdown-user-profile-link">مشاهده حساب کاربری<i class="la la-angle-left"></i></span>
                            </div>

                        </div>
                        <div class="c-header__profile-dropdown-account">

                            <div class="c-header__profile-dropdown-account-item">
                                <span class="c-header__profile-dropdown-account-item-title">نقش :</span>
                                <span class="c-header__profile-dropdown-account-item-amount">
                                    {{-- <span class="c-header__profile-dropdown-account-item-amount-number js-dc-point">۰</span> --}}
                                    {{trans('user::permissionmanager.function_name.'.backpack_user()->template)}}
                                </span>
                            </div>
                            @if (auth()->user()->hasSubscribtion())
                            <div class="c-header__profile-dropdown-account-item">
                                <span class="c-header__profile-dropdown-account-item-title">اشتراک :</span>
                                <span class="c-header__profile-dropdown-account-item-amount">
                                    {{-- <span class="c-header__profile-dropdown-account-item-amount-number js-dc-point">۰</span> --}}
                                    {{auth()->user()->getSubscribtionBrowse()}}
                                </span>
                            </div>
                            @endif
                        </div>
                        <a href="{{ route('profile.dashboard') }}" class="c-header__profile-dropdown-user-profile-full-link"></a>
                    </div>

                    <div class="c-header__profile-dropdown-actions">
                        {{-- @if (!auth()->user()->hasSubscribtion())
                        <div class="c-header__profile-dropdown-action-container">
                            <a href="{{route('subscribtion.view')}}" class="c-header__profile-dropdown-action c-header__profile-dropdown-action--activate-digiclub">
                                <span class="c-header__profile-dropdown-action-notification-badge"></span>
                                فعال سازی اشتراک
                            </a>
                        </div>
                        @endif --}}
                        <div class="c-header__profile-dropdown-action-container">
                            <a href="{{route('profile.info')}}" class="c-header__profile-dropdown-action c-header__profile-dropdown-action--orders "><i class="la la-user"></i> ویرایش مشخصات</a>
                        </div>
                        @if (backpack_user()->hasTemplate('customer'))
                        <div class="c-header__profile-dropdown-action-container">
                            <a href="{{route('profile.medical')}}" class="c-header__profile-dropdown-action c-header__profile-dropdown-action--history"><i class="la la-folder-o"></i>                        پرونده پزشکی                    </a>

                        </div>
                        @endif

                        <div class="c-header__profile-dropdown-action-container">
                            <a href="{{route('auth.logout')}}" class="c-header__profile-dropdown-action c-header__profile-dropdown-action--logout js-logout-button"><i class="la la-power-off"></i>خروج از حساب کاربری</a>
                        </div>
                    </div>
                </div>
            </li>
            @else
            <li class="nav-item">
                <a href="{{ route('auth.login') }}" type="button" class="button kt-modal-button button-info kt-register-button" data-modal="login">ورود | ثبت‌نام</a>
            </li>
            @endauth
            <li class="nav-item hidden-mobile chat-icon">
                <a target="_blank" href="{{ route('chatyno.index') }}" type="button" class="button button-chat kt-modal-button kt-login-button" data-modal="login"><i class="la la-comments"></i></a>
            </li>
        </ul>
    </nav>

    <script>
           // Mobile menu sidebar overlay
        document.addEventListener("turbolinks:load", function() {
            var sidebar = document.getElementsByClassName('sidebar-overlay');
            if (sidebar.length > 0) {
                $('html').removeClass('menu-opened');
                $('.sidebar-overlay').removeClass('opened');
                $('main-wrapper').removeClass('slide-nav');
            } else {
                $('body').append('<div class="sidebar-overlay"></div>');
            }

            $(document).on('click', '#mobile_btn', function() {
                $('main-wrapper').toggleClass('slide-nav');
                $('.sidebar-overlay').toggleClass('opened');
                $('html').addClass('menu-opened');
                return false;
            });

            $(document).on('click', '.sidebar-overlay', function() {
                $('html').removeClass('menu-opened');
                $(this).removeClass('opened');
                $('main-wrapper').removeClass('slide-nav');
            });

            $(document).on('click', '#menu_close', function() {
                $('html').removeClass('menu-opened');
                $('.sidebar-overlay').removeClass('opened');
                $('main-wrapper').removeClass('slide-nav');
            });
        })
    </script>
</header>
