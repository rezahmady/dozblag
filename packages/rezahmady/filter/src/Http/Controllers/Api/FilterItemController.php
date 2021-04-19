<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Rezahmady\Filter\Models\FilterItem;
use Illuminate\Http\Request;

class FilterItemController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        // NOTE: this is a Backpack helper that parses your form input into an usable array.
        // you still have the original request as `request('form')`
        $form = backpack_form_input();

        $options = FilterItem::query();

        // if no filter has been selected, show no options
        if (!isset($form['filter'])) {
            return [];
        }

        // if a filter has been selected, only show articles in that filter
        if ($form['filter']) {
            $options = $options->where('filter_id', $form['filter']);
        }

        if ($search_term) {
            $results = $options->where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return FilterItem::find($id);
    }
}
