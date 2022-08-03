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

mix.styles([
    'resources/css/admin.css',
], 'public/assets/admin/css/admin.css').version();

mix.styles([
    'resources/css/app.css',
], 'public/assets/css/app.css').version();

mix.js([
    "resources/js/admin.js",
    "resources/js/custom_admin.js",
], "public/assets/admin/js").version();
