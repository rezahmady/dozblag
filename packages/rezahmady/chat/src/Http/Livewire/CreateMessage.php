<?php

namespace Rezahmady\Chat\Http\Livewire;

use Livewire\Component;
use Rezahmady\Chat\Models\Room;
use Rezahmady\Chat\Events\MessageAdded;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Rezahmady\Chat\Models\Chat;

class CreateMessage extends Component
{

    use WithFileUploads;

    public $body;

    public $parent;

    public $reply;

    public $photos = [];

    public $voice;

    public $room;

    public $status;

    protected $listeners = [
        'rerenderCreateMessage',
        'refreshCreateMessage' => '$refresh'
    ];

    public function mount(Room $room)
    {
        $this->room = $room;
        if($room->user->id === auth()->id() and auth()->user()->template === 'customer') {
            $this->status = 'chat';
        } elseif($room->operator === null and $room->user->template === 'customer'){
            $this->status = 'suggest';
        } elseif($room->status === 'archive') {
            $this->status = 'archive';
        } else {
            $this->status = 'chat';
        }
    }

    public function rerenderCreateMessage(Room $room)
    {
        $this->room = $room;
        if($room->user->id === auth()->id() and auth()->user()->template == 'customer') {
            $this->status = 'chat';
        } elseif($room->operator === null and $room->user->template === 'customer'){
            $this->status = 'suggest';
        } elseif($room->status === 'archive') {
            $this->status = 'archive';
        } else {
            $this->status = 'chat';
        }
    }

    protected $rules = [
        'body' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        $message = Chat::create([
            'user_id'    => auth()->id(),
            'body'       => $this->body,
            'room_id'    => $this->room->id,
            'parent_id'  => $this->parent
        ]);
            
        $this->emit('message-added', $message->id);

        $sender = auth()->id();
        
        broadcast(new MessageAdded($this->room->id, $message->id, $sender))->toOthers();

        $this->resetProperties();        

    }

    public function acceptSuggestion()
    {
        $this->room->update(['operator_id' => auth()->id(), 'status' => 'chat']);
        $this->emitUp('refreshRooms');
        $this->status = 'chat';
    }

    public function cancelArchive()
    {
        $this->room->update(['status' => 'chat', 'status' => 'suggest']);
        $this->emitUp('refreshRooms');
        $this->status = 'chat';
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
        $destination = config('rezahmady.chat.uploud_voice_path').$voice;
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
            $destination = config('rezahmady.chat.uploud_photo_path').$photo->getFilename();
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
        return view('rezahmady.chat::skin.create-message');
    }
}
