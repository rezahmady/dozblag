<?php

namespace Modules\CoreUpdateWidget\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller
{
    public function update()
    {
        Artisan::call('core:update');
        \Alert::add('success', "با موفقیت بروز شد.")->flash();
        return redirect()->back();
    }
}
