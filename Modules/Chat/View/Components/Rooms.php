<?php

namespace Modules\Chat\View\Components;

use Illuminate\View\Component;
use Modules\Chat\Models\Room;

class Rooms extends Component
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
            $this->rooms = Room::where('user_id',$id)
            ->orWhere('doctor_id', $id)
            ->orWhere('operator_id', $id)
            ->whereHas('audience', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->with('latestMessage')
            ->get()->sortByDesc('latestMessage.created_at');
        } else {
            $id = auth()->id();
            $this->rooms = Room::where('user_id',$id)
            ->with('latestMessage')
            ->orWhere('doctor_id', $id)
            ->orWhere('operator_id', $id)
            ->get()->sortByDesc('latestMessage.created_at');
        }
        return view('chat::skin.rooms');
    }
}
