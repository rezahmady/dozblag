<?php

namespace Modules\Unity\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Unity\Models\Truck;

class TruckController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q'); // the search term in the select2 input

        // NOTE: this is a Backpack helper that parses your form input into an usable array.
        // you still have the original request as `request('form')`
        $form = backpack_form_input();

        $options = Truck::query();

        // if no category has been selected, show no options
        if (!isset($form['unity_id'])) {
            return [];
        }

        // if a category has been selected, only show articles in that category
        if ($form['unity_id']) {
            $options = $options->where('unity_id', $form['unity_id']);
        }

        if ($search_term) {
            $results = $options->where('transit_number', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return Truck::find($id);
    }
}
