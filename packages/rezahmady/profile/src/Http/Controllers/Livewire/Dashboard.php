<?php

namespace Rezahmady\Profile\Http\Controllers\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $user;

    public function mount()
    {
        $this->user = backpack_user()->withFakes();
    }

    public function render()
    {
        return view('theme::modules.profile.dashboard')->layout('theme::modules.profile.layouts.profile');
    }
}
