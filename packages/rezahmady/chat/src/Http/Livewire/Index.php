<?php

namespace Rezahmady\Chat\Http\Livewire;

use Livewire\Component;
use Rezahmady\Chat\Models\Room as RoomModel;
use Rezahmady\Chat\Http\Livewire\Traits\WithAudience;
use Rezahmady\Chat\Events\MessageSeen;
use Rezahmady\Chat\Events\MessageSeenResponse;


class Index extends Component
{
    use WithAudience;

    public $loadingRoom = false;

    public $currentRoom;
    
    public $onlineUsers;

    protected $listeners = [
        'ShowRoom',
        'prependMessageFromBroadcasting',
        'message-added'                                     => 'prependMessage',
        "refreshRooms"                                      => '$refresh',
        'echo-private:consultation.added,ConsultationAdded' => 'roomAdded',
        'echo-presence:chat,here'                           => 'setUsersHere',
        'edited-rooms'                                      => 'editedRooms',
    ];

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('playAudio');
    }

    public function setUsersHere($users) 
    {
        $this->onlineUsers = $users;
        $this->emit('refreshUserStatus', $users);
    }
    
    
    public function roomAdded() 
    {
        dd('room-added');
    }

    public function prependMessageFromBroadcasting($payload)
    {
        $this->prependMessage($payload['messageId']);
        $this->seenFromBroadcasting($payload);
    }

    public function seenFromBroadcasting($payload)
    {
        $this->currentRoom->messages()
        ->where('id', '<=', $payload['messageId'])
        ->where('user_id', $payload['sender'])
        ->update([
            'seen' => 1
        ]);

        broadcast(new MessageSeenResponse($this->currentRoom->id, $payload['messageId'], $payload['sender']))->toOthers();

    }

    public function prependMessage($id)
    {
        $this->dispatchBrowserEvent('scrollTo', ['hash' => "message-{$id}"]);
    }

    public function setRoom($id)
    {
        $this->currentRoom = RoomModel::findOrFail($id);
        $this->getAudience($this->currentRoom);
        $this->audience->status = 'در حال اتصال';
        $this->emit('rerenderCreateMessage', $this->currentRoom);
        // $this->emit('refreshUserStatus');
        $last = $this->currentRoom->messages()->latest('id')->first();
        if($last) {
            $this->seenMessages($last->id);
            $this->dispatchBrowserEvent('scrollTo', ['hash' => "message-{$last->id}"]);
        } else{
            $this->dispatchBrowserEvent('scrollToBottom');
        }
        
        $this->dispatchBrowserEvent('room-set');

    }

    public function cancelChat() {
        $this->currentRoom->update(['operator_id' => null]);
        $this->emit('rerenderCreateMessage',$this->currentRoom);
    }

    public function editedRooms() {
        $this->emit('rerenderCreateMessage',$this->currentRoom);
    }

    public function archiveChat() {
        $this->currentRoom->update(['status' => 'archive']);
        $this->emit('rerenderCreateMessage',$this->currentRoom);
    }
    public function cancelArchive() {
        $this->currentRoom->update(['status' => 'chat']);
        $this->emit('rerenderCreateMessage',$this->currentRoom);
    }

    public function seenMessages($messageId)
    {
        $messages = $this->currentRoom->messages()
        ->where('id', '<=', $messageId)
        ->where('user_id', '!=', auth()->id())
        ->update([
            'seen' => 1
        ]);

        broadcast(new MessageSeen($this->currentRoom->id))->toOthers();

    }

    public function ShowRoom()
    {
        $this->loadingRoom = false;
    }
    
    public function render()
    {
        return view('rezahmady.chat::skin.index')->layout('rezahmady.chat::skin.layouts.app');
    }
}
