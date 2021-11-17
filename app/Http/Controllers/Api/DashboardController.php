<?php

namespace App\Http\Controllers\Api;

use App\Models\Widget;
use Illuminate\Http\Request;

class DashboardController
{

    public function update_widget(Request $request)
    {
        $widget = \App\Services\Widget\Facades\Widget::update($request->widget);
        return response()->json(['data' => $widget]);
    }
}
