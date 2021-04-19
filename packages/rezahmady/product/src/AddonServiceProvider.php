<?php

namespace Rezahmady\Product;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'product';
    protected $commands = [];

    public function ModuleBoot(): void
    {
        //
    }
}
