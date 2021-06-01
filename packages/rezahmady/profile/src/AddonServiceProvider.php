<?php

namespace Rezahmady\Profile;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Profile\Http\Controllers\Livewire\Info;
use Rezahmady\Profile\Http\Controllers\Livewire\Medical;
use Rezahmady\Profile\View\Components\Sidebar;
use Rezahmady\Profile\View\Components\DoctorCounterWidget;
use Rezahmady\Profile\View\Components\DoctorPatientsWidget;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'profile';
    protected $commands = [];

    public function moduleBoot() :void
    {
        Blade::component('rezahmady.profile.sidebar', Sidebar::class);
        Blade::component('rezahmady.profile.doctor-counter-widget', DoctorCounterWidget::class);
        Blade::component('rezahmady.profile.doctor-patients-widget', DoctorPatientsWidget::class);
        Livewire::component('rezahmady.profile.http.controllers.livewire.info', Info::class);
        Livewire::component('rezahmady.profile.http.controllers.livewire.medical', Medical::class);
    }
}
