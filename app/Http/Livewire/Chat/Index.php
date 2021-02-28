<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;

class Index extends Component
{
    public $loadingRoom = false;

    public $currentRoom;

    protected $listeners = [
        'ShowRoom',
        'echo-private:consultation.added,ConsultationAdded' => 'roomAdded'
    ];
    
    public function roomAdded() 
    {
        dd('room-added');
    }

    public function ShowRoom()
    {
        $this->loadingRoom = false;
        // $this->currentRoom = 2;
        // dd($this->currentRoom);
        // $this->emit('setRoom',$this->currentRoom );
        // dd($this->currentRoom);
    }
    
    public function render()
    {
        return view('livewire.chat.index')->layout('livewire.chat.layouts.app');
    }
}
