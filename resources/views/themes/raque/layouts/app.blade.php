<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="{{ theme_option('meta_keywords') }}" >
    <meta name="description" content="{{ theme_option('meta_description') }}">
    <meta name="author" content="Reza Ahmadi Sabzevar">

    <!-- Links of CSS files -->
    @livewireStyles
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="{{ mix('/assets/raque/css/theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.css" integrity="sha512-NDcw4w5Uk5nra1mdgmYYbghnm2azNRbxeI63fd3Zw72aYzFYdBGgODILLl1tHZezbC8Kep/Ep/civILr5nd1Qw==" crossorigin="anonymous" />
    @stack('custom-style')
    <title>{{ theme_option('meta_title') }}</title>

    <link rel="icon" type="image/png" href="{{ theme('img/favicon.png') }}">

    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script> --}}
        <!-- The "defer" attribute is important to make sure Alpine waits for Livewire to load first. -->
    </head>

    <body>
        <!-- Start Header Area -->
        <header class="header-area p-relative">
            
            <div class="top-header top-header-style-four">
                <div class="container">
                    <div class="row align-items-center">
                        <livewire:widgets.menu :widget="widget('top_menu')" :view="'theme::widgets.menu.top_menu'" />

                        <div class="col-lg-4 col-md-4">
                            <ul class="top-header-login-register">
                                <li><a href="login.html"><i class='bx bx-log-in'></i> ورود</a></li>
                                <li><a href="register.html"><i class='bx bx-log-in-circle'></i> ثبت نام</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Navbar Area -->
            <div class="navbar-area navbar-style-three">
                <div class="raque-responsive-nav">
                    <div class="container">
                        <div class="raque-responsive-menu">
                            <div class="logo">
                                <a href="{{ route('home') }}">
                                    <livewire:partials.custom :view="'theme::partials.logo'" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="raque-nav">
                    <div class="container">
                        <nav class="navbar navbar-expand-md navbar-light">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <livewire:partials.custom :view="'theme::partials.logo'" />
                            </a>

                            <div class="collapse navbar-collapse mean-menu">
                                <livewire:widgets.menu :widget="widget('main_menu')" :view="'theme::widgets.menu.main_menu'" />


                                <div class="others-option">

                                    <div class="search-box d-inline-block">
                                        <i class='bx bx-search'></i>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- End Navbar Area -->

            <!-- Start Sticky Navbar Area -->
            <div class="navbar-area navbar-style-three header-sticky">
                <div class="raque-nav">
                    <div class="container">
                        <nav class="navbar navbar-expand-md navbar-light">
                            <a class="navbar-brand" href="{{ route('home')}}">
                                <livewire:partials.custom :view="'theme::partials.logo'" />
                            </a>

                            <div class="collapse navbar-collapse">
                                <livewire:widgets.menu :widget="widget('main_menu')" :view="'theme::widgets.menu.main_menu'" />

                                <div class="others-option">
                                    <div class="search-box d-inline-block">
                                        <i class='bx bx-search'></i>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- End Sticky Navbar Area -->
            
        </header>
        <!-- End Header Area -->


        <!-- search-box-layout -->
        <div class="search-overlay">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    
                    <div class="search-overlay-close">
                        <span class="search-overlay-close-line"></span>
                        <span class="search-overlay-close-line"></span>
                    </div>

                    <div class="search-overlay-form">
                        <form>
                            <input type="text" class="input-search" placeholder="جستجو ...">
                            <button type="submit"><i class='bx bx-search-alt'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- search-box-layout end -->


        {{ $slot }}


        <!-- Start Footer Area -->
        <footer class="footer-area">
            <div class="container">
                <div class="row">
                    
                    <livewire:widgets.custom :widget="widget('footer_contact_us')" :view="'theme::widgets.footer_contact_us'" />

                    <livewire:widgets.menu :widget="widget('footer_menu1')" :view="'theme::widgets.menu.footer_menu'" />

                    <livewire:widgets.menu :widget="widget('footer_menu2')" :view="'theme::widgets.menu.footer_menu'" />

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-footer-widget mb-30">
                            <h3>خبرنامه</h3>

                            <div class="newsletter-box">
                                <p>برای دریافت آخرین اخبار و آخرین به روزرسانی های ما</p>

                                <form class="newsletter-form" data-toggle="validator">
                                    <label>ایمیل شما:</label>
                                    <input type="email" class="input-newsletter" placeholder="ایمیل خود را وارد کنید" name="EMAIL" required autocomplete="off">
                                    <button type="submit">مشترک شدن</button>
                                    <div id="validator-newsletter" class="form-result"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-area">
                <livewire:partials.custom :view="'theme::partials.copyright'" />
            </div>
        </footer>
        <!-- End Footer Area -->
        
        <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

        <!-- Links of JS files -->
        <script src="{{ mix('/assets/raque/js/theme.js') }}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js" defer integrity="sha512-UU0D/t+4/SgJpOeBYkY+lG16MaNF8aqmermRIz8dlmQhOlBnw6iQrnt4Ijty513WB3w+q4JO75IX03lDj6qQNA==" crossorigin="anonymous"></script>
        @livewireScripts
        @stack('custom-script')
    </body>

</html>