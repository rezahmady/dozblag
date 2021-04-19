<?php

namespace Rezahmady\Chat\View\Components;

use Rezahmady\Chat\Models\Room;
use Illuminate\View\Component;

class Suggestions extends Component
{

    public $rooms;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rooms = Room::whereNull('operator_id')->WhereHas('user', function($q) {
            $q->where('template', 'customer');
        })->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('rezahmady.chat::skin.suggestions');
    }
}
