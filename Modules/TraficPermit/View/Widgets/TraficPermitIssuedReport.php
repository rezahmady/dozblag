<?php

namespace Modules\TraficPermit\View\Widgets;

use Carbon\Carbon;
use Illuminate\View\Component;
use Modules\TraficPermit\Models\Repository;

class TraficPermitIssuedReport extends Component
{
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $options = Repository::active()
        ->with(['types'])
        ->withCount(['traficpermits', 'availableTraficpermits', 'issuedTraficpermits', 'consumedTraficpermits', 'revokeTraficpermits'])

        // 1.countryb must be active
        ->whereHas('country',  function($q)  {
            $q->where('status', 1);
        })
        ->get();

        $options =


        $this->items = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('traficpermit::widgets.total-repository-report');
    }
}
