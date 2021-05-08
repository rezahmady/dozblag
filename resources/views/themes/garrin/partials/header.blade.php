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
            <a href="{{ route('home') }}" class="navbar-brand logo position-relative">
                <livewire:partials.custom :view="'theme::partials.logo'" />
            </a>
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
                                <img style="border-radius:20px;" src="{{auth()->user()->profile}}">
                            </div>
                                                
                            <div class="c-header__profile-dropdown-user-info">
                                <p class="c-header__profile-dropdown-user-name">{{auth()->user()->name}}</p>
                                    <span class="c-header__profile-dropdown-user-profile-link">مشاهده حساب کاربری<i class="la la-angle-left"></i></span>
                            </div>
                                        
                        </div>
                        <div class="c-header__profile-dropdown-account">
                                                                                                        
                            <div class="c-header__profile-dropdown-account-item">                                
                                <span class="c-header__profile-dropdown-account-item-title">نقش: {{trans('rezahmady.user::permissionmanager.function_name.'.backpack_user()->template)}}</span>         
                            </div>                                            
                        </div>                                
                        <a href="{{ route('profile.dashboard') }}" class="c-header__profile-dropdown-user-profile-full-link"></a>
                    </div>

                    <div class="c-header__profile-dropdown-actions">

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
            <li class="nav-item">
                <a target="_blank" href="{{ route('chatyno.index') }}" type="button" class="button button-chat kt-modal-button kt-login-button" data-modal="login"><img width="42px" src="{{url('/uploads/images/themes/garrin/support.svg')}}" alt=""></a>
            </li>
        </ul>
    </nav>
</header>