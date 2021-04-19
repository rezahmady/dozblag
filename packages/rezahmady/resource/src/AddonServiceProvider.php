<?php

namespace Rezahmady\Resource;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'resource';
    protected $commands = [];

    public function moduleBoot() : void
    {
        //
    }

    public function menuBuilder($menu)
    {
        if(backpack_user()->can('user manage')){
            $menu->add('resources', trans('rezahmady.resource::resource.resource_manage') , '#' , 200 , 'stethoscope');
            $menu->add('resources.resource', trans('rezahmady.resource::resource.resource_plural') , backpack_url('resource') , 210, 'hospital');
            if(backpack_user()->can('resource filter')) {
                $menu->add('resources.filter', trans('rezahmady.resource::resource.filtes') , backpack_url('resource/filter') , 220, 'archive');
                $menu->add('resources.filteritem', trans('rezahmady.resource::resource.filterItems') , backpack_url('resource/filteritem') , 230, 'filter');
            }
        } 

    }
}
