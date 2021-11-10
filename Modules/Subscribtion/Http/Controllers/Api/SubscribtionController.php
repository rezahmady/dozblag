<?php

namespace Modules\Subscribtion\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscribtion\Models\Subscribtion;

class SubscribtionController extends Controller
{
    public function subscribtion(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = Subscribtion::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = Subscribtion::paginate(10);
        }

        return $results;
    }

}
