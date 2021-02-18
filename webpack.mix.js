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
    'resources/views/themes/garrin/assets/plugins/bootstrap-rtl/css/bootstrap.min.css',
    'resources/views/themes/garrin/assets/plugins/fontawesome/css/fontawesome.min.css',
    'resources/views/themes/garrin/assets/plugins/fontawesome/css/all.min.css',
    'resources/views/themes/garrin/assets/plugins/fancybox/jquery.fancybox.min.css',
    'resources/views/themes/garrin/assets/css/style.css',
], 'public/assets/garrin/css/theme.css');

mix.scripts([
    'resources/views/themes/garrin/assets/js/jquery.min.js',
    'resources/views/themes/garrin/assets/js/popper.min.js',
    'resources/views/themes/garrin/assets/plugins/bootstrap-rtl/js/bootstrap.min.js',
    'resources/views/themes/garrin/assets/plugins/fancybox/jquery.fancybox.min.js',
    'resources/views/themes/garrin/assets/js/slick.js',
    'resources/views/themes/garrin/assets/js/script.js',
], 'public/assets/garrin/js/theme.js');

// mix.js("resources/js/app.js", "public/assets/js")
//     .postCss("resources/css/app.css", "public/assets/css", [

//         require("tailwindcss"),
//     ]);