<?php

namespace Rezahmady\User\Http\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
    public function render()
    {
        return view('theme::modules.user.auth.register')->layout('theme::layouts.app');
    }
}
