<?php

namespace Rezahmady\Chat\View\Components;

use Illuminate\View\Component;
use Rezahmady\Chat\Models\Room;

class Archives extends Component
{
    public $rooms;

    public $searchTerm;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchTerm)
    {
        $this->searchTerm = $searchTerm;
    }

    

    public function incrementUnread()
    {
        $this->unread++;
    }

    public function selectRoom()
    {
        $this->unread = 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if(strlen($this->searchTerm) > 0) {
            $searchTerm = '%'. $this->searchTerm .'%';
            $id = auth()->id();
            $this->rooms = Room::where('extras->status', 'archive')
            ->where('user_id',$id)
            ->orWhere('doctor_id', $id)
            ->orWhere('operator_id', $id)
            ->whereHas('audience', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->with('latestMessage')
            ->get()->sortByDesc('latestMessage.created_at');
        } else {
            $id = auth()->id();
            $this->rooms = Room::where('extras->status', 'archive')
            ->where('user_id',$id)
            ->with('latestMessage')
            ->orWhere('doctor_id', $id)
            ->orWhere('operator_id', $id)
            ->get()->sortByDesc('latestMessage.created_at');
        }
        return view('rezahmady.chat::skin.archives');
    }
}
