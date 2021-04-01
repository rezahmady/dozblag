const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
// mix.setPublicPath('/resources');
// mix.setResourceRoot('../')

// mix.js('resources/js/app.js', 'public/assets/admin/js')

mix.styles([
    'resources/views/themes/raque/assets/css/bootstrap..min.css',
    'resources/views/themes/raque/assets/css/boxicons.min.css',
    'resources/views/themes/raque/assets/css/flaticon.css',
    // 'resources/views/themes/raque/assets/css/fontawesome-all.css',
    'resources/views/themes/raque/assets/css/owl.carousel.min.css',
    'resources/views/themes/raque/assets/css/odometer.min.css',
    'resources/views/themes/raque/assets/css/meanmenu.min.css',
    'resources/views/themes/raque/assets/css/animate.min.css',
    'resources/views/themes/raque/assets/css/nice-select.min.css',
    'resources/views/themes/raque/assets/css/viewer.min.css',
    'resources/views/themes/raque/assets/css/slick.min.css',
    'resources/views/themes/raque/assets/css/magnific-popup.min.css',
    'resources/views/themes/raque/assets/css/style.css',
    'resources/views/themes/raque/assets/css/rtl.css',
    'resources/views/themes/raque/assets/css/responsive.css',
    'resources/views/themes/raque/assets/css/Vazir-FD.css'
], 'public/assets/raque/css/theme.css');

mix.scripts([
    'resources/views/themes/raque/assets/js/theme/jquery.min.js',
    'resources/views/themes/raque/assets/js/theme/popper.min.js',
    'resources/views/themes/raque/assets/js/theme/bootstrap.min.js',
    'resources/views/themes/raque/assets/js/theme/owl.carousel.min.js',
    'resources/views/themes/raque/assets/js/theme/mixitup.min.js',
    'resources/views/themes/raque/assets/js/theme/parallax.min.js',
    'resources/views/themes/raque/assets/js/theme/jquery.appear.min.js',
    'resources/views/themes/raque/assets/js/theme/odometer.min.js',
    'resources/views/themes/raque/assets/js/theme/particles.min.js',
    'resources/views/themes/raque/assets/js/theme/meanmenu.min.js',
    'resources/views/themes/raque/assets/js/theme/jquery.nice-select.min.js',
    'resources/views/themes/raque/assets/js/theme/viewer.min.js',
    'resources/views/themes/raque/assets/js/theme/slick.min.js',
    'resources/views/themes/raque/assets/js/theme/jquery.magnific-popup.min.js',
    'resources/views/themes/raque/assets/js/theme/jquery.ajaxchimp.min.js',
    'resources/views/themes/raque/assets/js/theme/form-validator.min.js',
    'resources/views/themes/raque/assets/js/theme/contact-form-script.js',
    'resources/views/themes/raque/assets/js/theme/main.js'
], 'public/assets/raque/js/theme.js');