<?php

use TorMorten\Eventy\Facades\Eventy;
use Modules\Page\Traits\PageTemplates;

if (!function_exists('get_page_templates')) {

    /**
     * Get all defined templates.
     */
    function get_page_templates()
    {
        $templates_trait = new \ReflectionClass(PageTemplates::class);
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        
        if (! count($templates)) {
            abort(503, trans('page::page.template_not_found'));
        }

        return $templates;
    }

}

if (!function_exists('get_page_templates_array')) {

    /**
     * Get all defined template as an array.
     *
     * Used to populate the template dropdown in the create/update forms.
     */
    function get_page_templates_array()
    {
        $templates = get_page_templates();

        $templates_array = [];
        
        foreach ($templates as $template) {
            $templates_array[$template->name] = trans('page::page.function_name.'.$template->name);
        }
        
        $templates_array = Eventy::filter('modules.page.filter.templates_array', $templates_array);

        return $templates_array;
    }

}