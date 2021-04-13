<?php

namespace App\Http\Livewire\User\Auth;

use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('theme::modules.user.auth.login')->layout('theme::layouts.app');
    }
}
