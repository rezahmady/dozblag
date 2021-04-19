<?php

namespace Rezahmady\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Rezahmady\User\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = User::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = User::paginate(10);
        }

        return $results;
    }

    public function doctors(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = User::where('name', 'LIKE', '%'.$search_term.'%')->where('template', 'doctor')->paginate(10);
        }
        else
        {
            $results = User::where('template', 'doctor')->paginate(10);
        }

        return $results;
    }

    public function operators(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = User::where('name', 'LIKE', '%'.$search_term.'%')->where('template', 'operator')->paginate(10);
        }
        else
        {
            $results = User::where('template', 'operator')->paginate(10);
        }

        return $results;
    }


}
