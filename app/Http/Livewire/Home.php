<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    // protected $listeners = ['lityClosed' => '$refresh'];
    public function render()
    {
        return view('theme::modules.pages.home')
        ->layout('theme::layouts.app');
    }
}
