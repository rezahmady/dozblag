<?php

return [
    

    'name' => 'ThemeManager',
    
    /*
    |--------------------------------------------------------------------------
    | theme folder
    |--------------------------------------------------------------------------
    |
    | location of theme folder.
    |
    */

    'themes_folder' => base_path('Themes'),

    'assets_folder' => '/themes/',

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
        'theme'            => \Modules\ThemeManager\Models\Theme::class,
    ],

];
