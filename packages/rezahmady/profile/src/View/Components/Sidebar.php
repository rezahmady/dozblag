<?php

namespace Rezahmady\Profile\View\Components;

use Illuminate\View\Component;
use Rezahmady\Profile\View\Traits\Auth;

class Sidebar extends Component
{

    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = backpack_user();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('theme::modules.profile.partials.sidebar');
    }
}
