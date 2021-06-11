<?php

namespace Rezahmady\Filter;

use Javoscript\MacroableModels\Facades\MacroableModels;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Filter\Http\Livewire\Widgets\FilterItem;
use Rezahmady\Filter\Models\FilterItem as ModelsFilterItem;
use App\Models\User;
use Rezahmady\Filter\Http\Livewire\FilterItemPage;
use Rezahmady\Filter\Models\Filter;
use Rezahmady\Resource\Models\Resource;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'filter';
    protected $commands = [];

    public function moduleBoot(): void
    {
        Livewire::component('widgets.filter-item', FilterItem::class);
        Livewire::component('rezahmady.filter.http.livewire.filter-item-page', FilterItemPage::class);
        $this->resolveModelsEloquent();
    }

    public function resolveModelsEloquent()
    {

        User::resolveRelationUsing('speciltyFilter', function ($Model) {
            return $Model->belongsTo(ModelsFilterItem::class, 'extras->filter_specilty');
        });


        MacroableModels::addMacro(User::class, 'servicesFilter', function() {
            $user = $this;
            return Filter::findBySlug('services')->items->filter(function($filteritem) use ($user) {
                if(isset($user->extras->filter_services))
                    return in_array($filteritem->id, $user->extras->filter_services) ;
                return false;
            });
        });


        MacroableModels::addMacro(Resource::class, 'servicesFilter', function() {
            $user = $this;
            return Filter::findBySlug('services')->items->filter(function($filteritem) use ($user) {
                if(isset($user->extras->filter_services))
                    return in_array($filteritem->id, $user->extras->filter_services) ;
                return false;
            });
        });

        MacroableModels::addMacro(User::class, 'getSpecilty', function() {
            return ($this->speciltyFilter) ? $this->speciltyFilter->name : '';
        });
    }
}
