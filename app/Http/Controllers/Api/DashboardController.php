<?php

namespace App\Http\Controllers\Api;

class DashboardController
{
    public function get_widgets() {

        $widgets =
        [
            [
                'id'  => 1,
                'lg'  => 'col-lg-3',
                'md'  => 'col-md-3',
                'sm'  => 'col-sm-6',
                'xsm' => 'col-12',
            ],
            [
                'id'  => 2,
                'lg'  => 'col-lg-3',
                'md'  => 'col-md-3',
                'sm'  => 'col-sm-6',
                'xsm' => 'col-12',
            ],
            [
                'id'  => 3,
                'lg'  => 'col-lg-3',
                'md'  => 'col-md-3',
                'sm'  => 'col-sm-6',
                'xsm' => 'col-12',
            ],
            [
                'id'  => 4,
                'lg'  => 'col-lg-3',
                'md'  => 'col-md-3',
                'sm'  => 'col-sm-6',
                'xsm' => 'col-12',
            ],
            [
                'id'  => 5,
                'lg'  => 'col-lg-6',
                'md'  => 'col-md-6',
                'sm'  => 'col-sm-12',
                'xsm' => 'col-12',
            ],
        ];

        return response()->json(['data' => json_encode($widgets)]);
    }

}
