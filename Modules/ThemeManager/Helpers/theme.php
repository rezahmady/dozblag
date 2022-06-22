<?php

use App\Models\Widget;

if (!function_exists('theme_option')) {

    function theme_option($key, $default = null)
    {
        $theme_model = config('thememanager.models.theme');

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
        return asset(config('thememanager.assets_folder').'/'.THEME_FOLDER.'/'.$path);

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
        return config('thememanager.themes_folder') .'/'. THEME_FOLDER .'/'. $folder_file;
    }
}

if (!function_exists('theme_folder_url')) {
    function theme_folder_url($folder_file = '')
    {
        return url('themes/' . THEME_FOLDER . $folder_file);
    }
}

if (!function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $value
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = array();
            }

            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}