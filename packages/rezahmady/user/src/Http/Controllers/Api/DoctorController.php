<?php

namespace Rezahmady\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Rezahmady\User\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        // NOTE: this is a Backpack helper that parses your form input into an usable array.
        // you still have the original request as `request('form')`
        $form = backpack_form_input();

        $options = User::query();

        // if no template has been selected, show no options
        if (!isset($form['template'])) {
            return [];
        }

        // if a template has been selected, only show articles in that template
        if ($form['template']) {
            $options = $options->where('template', $form['template']);
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
        return User::find($id);
    }
}
