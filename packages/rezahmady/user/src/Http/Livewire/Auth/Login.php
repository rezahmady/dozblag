<?php

namespace Rezahmady\User\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class Login extends Component
{

    public $user = null;

    public $step = 1;

    protected $listeners = ['added-user' => 'nextStep', 'reset-form-holder' => 'resetForm', 'reset-render' => 'render'];

    public function mount()
    {
        if(session()->has('validation_code') and session()->has('mobile')) {
            $this->user = User::where('mobile', session('mobile'))->first();
            $this->step = 2;
        }
    }

    public function resetForm()
    {
        session()->forget('validation_code');
        session()->forget('mobile');
        $this->redirect('#');
    }

    public function nextStep(User $user)
    {
        $this->user = $user;
        $this->step = 2;
    }

    public function render()
    {
        return view('theme::modules.user.auth.login')->layout('theme::layouts.app');
    }
}
