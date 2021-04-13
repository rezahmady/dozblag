<?php

namespace App\Http\Livewire\User\Auth;

use Livewire\Component;

class Register extends Component
{
    public function render()
    {
        return view('theme::modules.user.auth.register')->layout('theme::layouts.app');
    }
}
