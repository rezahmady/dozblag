<?php

namespace Rezahmady\Resource;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Resource\Http\Livewire\ClinicList;
use Rezahmady\Resource\Http\Livewire\HospitalList;
use Rezahmady\Resource\Http\Livewire\ResourceList;
use TorMorten\Eventy\Facades\Eventy;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'resource';
    protected $commands = [];

    public function moduleBoot() : void
    {
        Livewire::component('rezahmady.resource.http.livewire.resource-list', ResourceList::class);

        Eventy::addAction('admin-menu-build', function($menu) { 
            if(backpack_user()->can('user manage')){
                $menu->add('resources', trans('rezahmady.resource::resource.resource_manage') , '#' , 200 , 'stethoscope');
                $menu->add('resources.resource', trans('rezahmady.resource::resource.resource_plural') , backpack_url('resource') , 210, 'hospital');
                if(backpack_user()->can('resource filter')) {
                    $menu->add('resources.filter', trans('rezahmady.resource::resource.filtes') , backpack_url('resource/filter') , 220, 'archive');
                    $menu->add('resources.filteritem', trans('rezahmady.resource::resource.filterItems') , backpack_url('resource/filteritem') , 230, 'filter');
                }
            } 
        }, 20, 1);
    }
}
