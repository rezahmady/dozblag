<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Room;
use App\Events\Chat\MessageAdded;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateMessage extends Component
{

    use WithFileUploads;

    public $body;

    public $parent;

    public $reply;

    public $photos = [];

    public $voice;

    public $room;

    protected $listeners = [
        'rerenderCreateMessage',
    ];

    public function mount(Room $room)
    {
        $this->room = $room;
    }

    public function rerenderCreateMessage(Room $room)
    {
        $this->room = $room;
    }

    protected $rules = [
        'body' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        $message = auth()->user()->messages()->create([
            'body'       => $this->body,
            'room_id'    => $this->room->id,
            'parent_id'  => $this->parent
        ]);
            
        $this->emit('message-added', $message->id);

        $sender = auth()->id();
        
        broadcast(new MessageAdded($this->room->id, $message->id, $sender))->toOthers();

        $this->resetProperties();        

    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:5024',
        ]);
    }

    public function saveVoice($voice)
    {
        
        $resource = "/.tmb/voice/{$voice}";
        $destination = "uploads/chat/voice/{$voice}";
        if(Storage::disk('local')->exists($resource)) Storage::disk('local')->move($resource, $destination);

        $message = auth()->user()->messages()->create([
            'body'       => $voice,
            'room_id'    => $this->room->id,
            'parent_id'  => $this->parent,
            'type'       => 'voice',
        ]);
            
        $this->emit('message-added', $message->id);

        $sender = auth()->id();
        
        broadcast(new MessageAdded($this->room->id, $message->id, $sender))->toOthers();

        $this->resetProperties();
    }

    public function savePhotos()
    {

    
        $filenames = [];
        foreach ($this->photos as $photo) {
            // $photo->store('/uploads/chat/photo');
            array_push($filenames, $photo->getFilename());
            $resource = "/livewire/preview-file/{$photo->getFilename()}";
            $destination = "uploads/chat/photo/{$photo->getFilename()}";
            if(Storage::disk('local')->exists($resource)) Storage::disk('local')->move($resource, $destination);
        }

        $message = auth()->user()->messages()->create([
            'body'       => json_encode($filenames),
            'room_id'    => $this->room->id,
            'parent_id'  => $this->parent,
            'type'       => 'photos',
        ]);
            
        $this->emit('message-added', $message->id);

        $sender = auth()->id();
        
        broadcast(new MessageAdded($this->room->id, $message->id, $sender))->toOthers();

        $this->resetProperties();
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function resetProperties()
    {
        $this->body = $this->parent_id = $this->score = $this->reply = $this->photos = null;
    }

    public function render()
    {
        return view('livewire.chat.create-message');
    }
}
