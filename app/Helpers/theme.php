<?php

use App\Models\Widget;

if (!function_exists('theme_option')) {

    function theme_option($key, $default = null)
    {
        $theme_model = config('themes.models.theme');

        $theme = $theme_model::where('active', '=', 1)->first();

        if(isset($theme->extras[$key])){
            return $theme->extras[$key];
        };

        return $default;
    }

}

if (!function_exists('theme')) {

    function theme($path = '')
    {
        return asset(config('themes.assets_folder').'/'.THEME_FOLDER.'/'.$path);

    }

}

if (!function_exists('widget')) {

    function widget($name)
    {
        return Widget::where('name', $name)->where('theme_id', THEME_ID)->first();
    }

}

if (!function_exists('theme_folder')) {
    function theme_folder($folder_file = '')
    {
        return 'themes/' . THEME_FOLDER . $folder_file;
    }
}

if (!function_exists('theme_path')) {
    function theme_path($folder_file = '')
    {
        return config('themes.themes_folder') .'/'. THEME_FOLDER .'/'. $folder_file;
    }
}

if (!function_exists('theme_folder_url')) {
    function theme_folder_url($folder_file = '')
    {
        return url('themes/' . THEME_FOLDER . $folder_file);
    }
}