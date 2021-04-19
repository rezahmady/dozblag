<?php

namespace Rezahmady\Filter;

use Javoscript\MacroableModels\Facades\MacroableModels;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Filter\Http\Livewire\Widgets\FilterItem;
use Rezahmady\Filter\Models\FilterItem as ModelsFilterItem;
use Rezahmady\User\Models\User;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'filter';
    protected $commands = [];

    public function moduleBoot(): void
    {
        Livewire::component('widgets.filter-item', FilterItem::class);
        $this->resolveModelsEloquent();
    }

    public function resolveModelsEloquent()
    {
        User::resolveRelationUsing('specilty', function ($Model) {
            return $Model->belongsTo(ModelsFilterItem::class, 'extras->specialty_id');
        });

        MacroableModels::addMacro(User::class, 'getSpecilty', function() {
            return ($this->specilty) ? $this->specilty->name : '';
        });
    }
}
