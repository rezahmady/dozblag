<?php

return [

    /*
    |--------------------------------------------------------------------------
    | theme folder
    |--------------------------------------------------------------------------
    |
    | location of theme folder.
    |
    */

    'themes_folder' => base_path('Themes'),

    'assets_folder' => '/assets',

    /*
    |--------------------------------------------------------------------------
    | assets
    |--------------------------------------------------------------------------
    |
    | if is true assets of acitve  them will be publish in public folder
    |
    */

    'publish_assets' => false,

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Models used in the Theme and ThemeOptions CRUDs.
    |
    */

    'models' => [
        'theme'            => \App\Models\Theme::class,
    ],

];
