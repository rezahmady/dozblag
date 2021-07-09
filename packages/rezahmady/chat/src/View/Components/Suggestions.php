<?php

namespace Rezahmady\Chat\View\Components;

use Rezahmady\Chat\Models\Room;
use Illuminate\View\Component;

class Suggestions extends Component
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
            $this->rooms = Room::whereNull('operator_id')
            ->WhereHas('user', function($q) use ($searchTerm) {
                $q->where('template', 'customer')->where('name', 'like', $searchTerm);
            })
            ->get()->sortByDesc('latestMessage.created_at');
        } else {
            $this->rooms = Room::whereNull('operator_id')->WhereHas('user', function($q) {
                $q->where('template', 'customer');
            })
            ->get();
        }
        return view('rezahmady.chat::skin.suggestions');
    }
}
