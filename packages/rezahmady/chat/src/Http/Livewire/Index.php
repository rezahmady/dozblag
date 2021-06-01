<?php

namespace Rezahmady\Chat\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    public $expireDate;
    
    public $unseenNewConsoltation = 1;

    protected $listeners = [
        'ShowRoom',
        'prependMessageFromBroadcasting',
        'message-added'                                     => 'prependMessage',
        "refreshRooms"                                      => '$refresh',
        'echo-private:consultation.added,ConsultationAdded' => 'roomAdded',
        'echo-presence:chat,here'                           => 'setUsersHere',
        'edited-rooms'                                      => 'editedRooms',
        'room-started'                                      => 'roomStarted',
        'room-end'                                          => 'closeRoom',
    ];

    public function mount($id = null)
    {
        if($id) {
            $this->currentRoom = RoomModel::where(DB::raw('md5(id)'), $id)->first();
            $this->getAudience($this->currentRoom);
            $this->audience->status = 'در حال اتصال';
            $this->expireDate = $this->currentRoom->extras['expire_date'];
            $this->prependMessage();
        }
    }

    public function resetUnseen()
    {
        $this->unseenNewConsoltation = 0;
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('playAudio');
    }

    public function closeRoom()
    {
        $this->emit('rerenderCreateMessage', $this->currentRoom);
    }

    public function setUsersHere($users) 
    {
        $this->onlineUsers = $users;
        $this->emit('refreshUserStatus', $users);
    }
    
    
    public function roomAdded($payload) 
    {
        $room = RoomModel::find($payload['roomId']);
        $user = backpack_user();
        if(($user->id == $room->user_id) or ($user->id == $room->doctor_id) or ($user->template == 'operator_id')) {
            $this->unseenNewConsoltation = $this->unseenNewConsoltation+1;
            $this->emitSelf('refreshRooms');
        };

    }

    public function prependMessageFromBroadcasting($payload)
    {
        $this->prependMessage();
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

    public function roomStarted() {
        $this->expireDate = $this->currentRoom->extras['expire_date'];
        $this->dispatchBrowserEvent('room-set-time', ['expire_date'=> $this->expireDate ]);
    }

    public function prependMessage()
    {
        // $this->dispatchBrowserEvent('scrollTo', ['hash' => "message-{$id}"]);
        $this->dispatchBrowserEvent('scrollToBottom');
    }

    public function setRoom($id)
    {
        $this->currentRoom = RoomModel::findOrFail($id);
        $this->getAudience($this->currentRoom);
        $this->audience->status = 'در حال اتصال';
        $this->expireDate = $this->currentRoom->extras['expire_date'];
        $this->emit('rerenderCreateMessage', $this->currentRoom);
        $this->dispatchBrowserEvent('scrollToBottom');
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
