@extends(backpack_view('blank'))
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.1.119/styles/kendo.bootstrap-v4.min.css">

@php

    // $widgets['before_content'][] = [
    //     'type'    => 'div',
    //     'class'   => 'row',
    //     'content' => [ // widgets 
    //         [
    //             'type'        => 'progress',
    //             'class'       => 'card text-white bg-success mb-2',
    //             'value'       => '11.456',
    //             'description' => 'کاربر ثبت نام کرده است.',
    //             'progress'    => 57, // integer
    //             'hint'        => 'ظرفیت باقی مانده ۱۳۰ کاربر',
    //         ],
    //         [
    //             'type'        => 'progress',
    //             'class'       => 'card text-white bg-primary mb-2',
    //             'value'       => '11.456',
    //             'description' => 'Registered users.',
    //             'progress'    => 87, // integer
    //             'hint'        => '8544 more until next milestone.',
    //         ]
    //     ]
    //  ];

    use Backpack\CRUD\app\Library\Widget;

    // alternatively, use a fluent syntax to define each widget attribute
    // Widget::add([
    //     'type'     => 'view',
    //     'view'     => 'widgets.trello',
    //     'someAttr' => 'some value',
    // ])
    // ->to('before_content');

    // Widget::add([
    //     'type'     => 'view',
    //     'view'     => 'widgets.tileLayout',
    //     'someAttr' => 'some value2',
    // ])
    // ->to('before_content');


@endphp

@section('content')

@endsection