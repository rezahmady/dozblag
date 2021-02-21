<?php

namespace App\Http\Controllers\Admin\Chat;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.chat.index')->layout('livewire.chat.layouts.app');
    }
}
