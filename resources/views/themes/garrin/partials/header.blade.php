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
            @action('site.header-left-content-before-search::action', false)

            <li class="nav-item hidden-mobile chat-icon">
                <button type="button" x-data  x-on:click.privent="$store.search.toggle()" class="button button-chat kt-modal-button kt-login-button" ><i class="la la-search"></i></button>
            </li>

            @action('site.header-left-content-after-search::action', false)
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
