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
            <li class="nav-item">
                <a href="{{ route('auth.login') }}" type="button" class="button kt-modal-button button-info kt-register-button" data-modal="login">ورود | ثبت‌نام</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('auth.login') }}" type="button" class="button button-chat kt-modal-button kt-login-button" data-modal="login"><img width="42px" src="http://gariin.test/uploads/images/support.svg" alt=""></a>
            </li>
        </ul>
    </nav>
</header>