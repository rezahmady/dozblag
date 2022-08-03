<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\HasWidget;
use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;

class Home extends Component
{
    use WithAlert, HasWidget;

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function render()
    {
        return view('theme::modules.pages.home');
    }
}
