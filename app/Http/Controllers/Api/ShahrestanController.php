<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shahrestan;
use Illuminate\Http\Request;

class ShahrestanController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        // NOTE: this is a Backpack helper that parses your form input into an usable array.
        // you still have the original request as `request('form')`
        $form = backpack_form_input();

        $options = Shahrestan::query();

        // if no ostan has been selected, show no options
        if (!isset($form['ostan_id'])) {
            return [];
        }

        // if a ostan has been selected, only show articles in that ostan
        if ($form['ostan_id']) {
            $options = $options->where('ostan_id', $form['ostan_id']);
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
        return Shahrestan::find($id);
    }
}
