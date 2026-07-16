<?php

namespace Modules\TraficPermit\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TraficPermit\Models\TraficPermitTemplate;
use Modules\TraficPermit\Models\TraficPermitType;

class TraficPermitTemplateController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q'); // the search term in the select2 input

        // NOTE: this is a Backpack helper that parses your form input into an usable array.
        // you still have the original request as `request('form')`
        $form = backpack_form_input();

        $options = TraficPermitTemplate::query();

        // if no country_id and types has been selected, show no options
        if (!isset($form['country_id'])) {
            return [];
        }

        // if country match
        $options = $options->where('country_id', $form['country_id']);
        
        // if is active
        $options = $options->where('status', 1);

        // match search term
        if ($search_term) {
            $results = $options->where('title', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return TraficPermitTemplate::find($id);
    }
}
