<?php

namespace Rezahmady\Subscribtion;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Subscribtion\Http\Livewire\Subscribtion;
use TorMorten\Eventy\Facades\Eventy;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'subscribtion';
    protected $commands = [];


    public function moduleBoot() : void
    {
        Livewire::component('rezahmady.subscribtion.http.livewire.subscribtion', Subscribtion::class);

        Eventy::addAction('admin-menu-build', function($menu) { 
            if(backpack_user()->can('subscribtion manage')){
                $menu->add('subscribtion', ' اشتراک ها', backpack_url('subscribtion') , 100 , 'hand-pointer');
            }
        }, 20, 1);
    }
}
