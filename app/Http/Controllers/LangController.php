<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function change(Request $request)
    {
        if (! in_array($request->locale, ['fa', 'en'])) {
            abort(400);
        }
        
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
  
        return redirect()->back();
    }
}