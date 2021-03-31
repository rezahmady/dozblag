<?php
namespace App\Http\Livewire\Traits;

trait WithAudience {
    
    public $audience;

    public $rool;

    public function getAudience($room)
    {
        if(auth()->id() === $room->user->id) {
            $this->audience = ($room->doctor) ? $room->doctor : $room->operator ?? null;
        } elseif($room->doctor and auth()->id() === $room->doctor->id) {
            $this->audience = ($room->user) ? $room->user : $room->operator ?? null;
        } elseif($room->operator and auth()->id() === $room->operator->id) {
            $this->audience = ($room->user) ? $room->user : $room->doctor ?? null;
        } else {
            $this->audience = $room->user;
        }
        
        switch ($this->audience->template) {
            case 'customer':
                $this->rool = "مراجعه کننده";
                break;
            case 'doctor':
                $this->rool = "پزشک";
                break;        
            case 'operator':
                $this->rool = "اپراتور";
                break; 
            default:
                $this->rool = "مراجعه کننده";
                break;
        }
    }
}