<?php

namespace Rezahmady\Subscribtion\Http\Livewire;

use Livewire\Component;
use Rezahmady\Subscribtion\Models\Subscribtion as ModelsSubscribtion;

class Subscribtion extends Component
{
    public $packages;

    protected $listeners = ['update-page' => '$refresh'];

    public function mount()
    {
        $this->packages = ModelsSubscribtion::where('extras->status', 1)->get();
    }

    public function render()
    {
        return view('theme::modules.subscribtion.index');
    }
}
