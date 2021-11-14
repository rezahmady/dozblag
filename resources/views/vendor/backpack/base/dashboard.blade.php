@extends(backpack_view('blank'))
{{-- <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.1.119/styles/kendo.bootstrap-v4.min.css"> --}}
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

    // alternatively, use a fluent syntax to define each widget attribute
    // Widget::add([
    //     'type'     => 'view',
    //     'view'     => 'widgets.timer-sse',
    //     'someAttr' => 'some value',
    // ])
    // ->to('before_content');


@endphp

@section('content')
    <!-- Alpine Plugins -->
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tooltip.js/1.3.3/tooltip.min.js" integrity="sha512-ql/3IzUzLuFdkLA2w9moj4ssGDZuvRTjRDeSEX+MnjrzjRpy1COnClBDprSR0KPWbpyxVMvjiLHgv0KFa+H8vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Alpine Core -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/muuri@0.9.5/dist/muuri.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/web-animations-js@2.3.2/web-animations.min.js"></script>

    <style>
        .bg-warning.bg-shining {
            background-image: linear-gradient(180deg,#ffcf69,#f9c659);
            box-shadow: rgb(255 207 105 / 51%) 0 5px 35px !important;
            border:0 !important;
        }

        .bg-success.bg-shining {
            box-shadow: rgb(142 213 87 / 34%) 0 5px 15px !important;
            background-image: linear-gradient(180deg,#aae181,#89d351) !important;
            border:0 !important;
        }

        .bg-primary.bg-shining {
            box-shadow: rgb(87 187 213 / 34%) 0 5px 15px !important;
            background-image: linear-gradient(180deg,#98deff,#6cc2ff) !important;
            border:0 !important;
        }

        .bg-purple.bg-shining {
            box-shadow: rgb(179 87 213 / 34%) 0 5px 15px !important;
            background-image: linear-gradient(180deg,#ef98ff,#f96dfb) !important;
            border:0 !important;
        }

        .setting-btn {
            position: absolute;
            left: 0;
            top: -44px;
        }

        .setting-tools {
            position: absolute;
            right: 14px;
            top: 0;
            color: #4e577f;
            z-index: 100;
            font-size: 16px;
            display: flex;
            background: white;
            padding: 2px;
            border-radius: 0 5px 0 5px;
        }

        .grid {
            position: relative;
        }
        .item {
            position: absolute;
            z-index: 1;
        }
        .item.muuri-item-hidden {
            z-index: 0;
        }
        .item.muuri-item-releasing {
            z-index: 2;
        }
        .item.muuri-item-dragging {
            z-index: 3;
        }
        .item.muuri-item-dragging .item-content,
        .item.muuri-item-releasing .item-content {
            background: #FFCDD2;
        }
        .handle {
            cursor: pointer;
        }
        .layout-holder {
            width: 155px;
            justify-content: center;
            display: flex;
            padding: 10px;
            font-size: 28px;
            color: #4e577f;
            flex-flow: wrap;
        }
        .layout-label {
            font-size: 13px;
        }
        .layouts-holder {
            width: 310px;
            flex-wrap: wrap;
            border-radius: 10px;
        }

        .layout_html {
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
            left: 0;
            margin: auto;
            width: 100%;
            background: #d6dce159;
            height: 100%;
        }

        .layouts-holder {
            width: 310px;
            flex-wrap: wrap;
            border-radius: 10px;
            position: absolute;
            right: 0;
            left: 0;
            margin: auto;
            top: 20%;
        }

    </style>

    <div class="position-relative" x-data="widget_layout">
        <button x-ref="editbtn" x-on:click.prevent="toggle()" :class="edit ? 'btn btn-success setting-btn' : 'btn btn-secondary setting-btn' "   data-toggle="tooltip" data-placement="right" title="" :data-original-title="edit ? 'اتمام ویرایش' : 'شروع ویرایش' " data-style="zoom-in"><span class="ladda-label"><i class="la la-cog"></i></span></button>
        <div class="row grid" >
            <div x-data="widget('1')" @widgets-updated-1.window="update_class($event.detail)" data-id="1" :class="columns" class="item">
                <div class="card text-white bg-warning bg-shining">
                    <div class="card-body">
                        <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-user"></i></button>
                        <div class="text-value">9.823</div>
                        <div>کاربران</div>
                    </div>

                </div>
            </div>
            <div x-data="widget('2')" @widgets-updated-2.window="update_class($event.detail)" data-id="2" :class="columns" class="item">
                <div class="card text-white bg-success bg-shining">
                    <div class="card-body">
                        <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-stethoscope"></i></button>
                        <div class="text-value">9.823</div>
                        <div>پزشکان</div>
                    </div>

                </div>
            </div>
            <div x-data="widget('3')" @widgets-updated-3.window="update_class($event.detail)" data-id="3" :class="columns" class="item">
                <div class="card text-white bg-primary bg-shining">
                    <div class="card-body">
                        <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-comments-o"></i></button>
                        <div class="text-value">9.823</div>
                        <div>گفت و گوها</div>
                    </div>
                </div>
            </div>
            <div x-data="widget('4')" @widgets-updated-4.window="update_class($event.detail)" data-id="4" :class="columns" class="item">
                <div class="card text-white bg-purple bg-shining">
                    <div class="card-body">
                        <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-comment"></i></button>
                        <div class="text-value">9.823</div>
                        <div>نظرات</div>
                    </div>
                </div>
            </div>
            <div x-data="widget('5')" @widgets-updated-5.window="update_class($event.detail)" data-id="5" :class="columns" class="item">
                <div class="card text-white bg-info">
                    <div class="card-header">Card title</div>
                    <div class="card-body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</div>
                </div>
            </div>
        </div>

        <div class="layout_html" x-show="layout_settings"  >
            <div class="d-flex layouts-holder bg-gray-100" x-on:click.outside="layouts_hide()">
                <template x-for="layout in layouts" :key="layout.id">
                    <div  x-data="layoutdata(layout.label)" class="d-flex ltr layout-holder">
                        <div class="d-block w-100 m-auto text-center"><i :class="layout.icon" class="la"></i></div>
                        <template x-for="(star, index) in ratings" :key="index">
                            <i class="la" @click="rate(star.amount, $dispatch)" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating"
                               aria-hidden="true"
                               class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline p-1 w-12 m-0 cursor-pointer"
                               :class="{'la-square': (rating >= star.amount || hoverRating >= star.amount), 'la-square-o': (rating < star.amount || hoverRating < star.amount), }">
                            </i>

                        </template>
                        <div class="layout-label p-2">
                            <template x-if="rating || hoverRating">
                                <p x-text="currentLabel()"></p>
                            </template>
                            <template x-if="!rating && !hoverRating">
                                <p>انتخاب کنید</p>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>



        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('widget_layout', function () {
                return {
                    edit: this.$persist(false),
                    layout_settings: false,
                    layouts_show(widget_id) {
                        this.$store.dashboard.active_widget_id = widget_id;
                        this.layout_settings = true
                    },
                    layouts_hide() {
                        this.layout_settings = false
                    },
                    layouts: [
                        {'id': 1, 'label': 'lg', 'icon': 'la-television'},
                        {'id': 2, 'label': 'md', 'icon': 'la-laptop'},
                        {'id': 3, 'label': 'sm', 'icon': 'la-tablet'},
                        {'id': 4, 'label': 'xsm', 'icon': 'la-mobile'},
                    ],
                    toggle() {
                        this.edit = ! this.edit
                    }
                }
            });

            Alpine.data('widget', function (id) {
                return {
                    widget_id: id,
                    columns: '',
                    toggle() {
                        this.edit = ! this.edit
                    },
                    init() {
                        // this.$watch(this.$store.dashboard.widgets, value => console.log(value));

                        // $(document).on('widgets-updated-'+this.widget_id, function(event, instance) {
                        //     const widget = event.detail.widget;
                        //     console.log(widget.id, this.columns)
                        //     this.columns = `${widget.col_lg} ${widget.col_md} ${widget.col_sm} ${widget.col_xsm}`;
                        // });
                        const data = this.$store.dashboard.widgets.find(element => element.id == this.widget_id);
                        this.columns = `${data.col_lg} ${data.col_md} ${data.col_sm} ${data.col_xsm}`
                        const tools = document.createElement('span')
                        tools.setAttribute('class', 'setting-tools');
                        tools.setAttribute('x-show', `edit`);

                        const column = document.createElement('i')
                        column.setAttribute('class', 'la la-columns');
                        column.setAttribute('x-on:click', `layouts_show('${this.widget_id}')`);

                        const move = document.createElement('i')
                        move.setAttribute('class', 'la la-arrows handle mr-2');

                        tools.appendChild(move)
                        tools.appendChild(column)

                        this.$el.appendChild(tools)
                    },
                    update_class(detail) {
                        const { widget } = detail;
                        this.columns = `${widget.col_lg} ${widget.col_md} ${widget.col_sm} ${widget.col_xsm}`;
                        console.log(detail)
                    }
                }
            })

            Alpine.data('layoutdata', function (device) {
                return {
                    device: device,
                    rating: 0,
                    hoverRating: 0,
                    ratings: [
                        {'amount': 1, 'label': (device !== 'xsm') ? 'col-'+device+'-3' : 'col-3'},
                        {'amount': 2, 'label': (device !== 'xsm') ? 'col-'+device+'-6' : 'col-6'},
                        {'amount': 3, 'label': (device !== 'xsm') ? 'col-'+device+'-9' : 'col-9'},
                        {'amount': 4, 'label': (device !== 'xsm') ? 'col-'+device+'-12' : 'col-12'},
                    ],
                    rate(amount, dispatch) {
                        // const widget_id = this.$store.dashboard.active_widget_id;
                        const data = this.ratings.find(element => element.amount === amount);
                        if (this.rating === amount) {
                            this.rating = 0;
                            this.$store.dashboard.set_col(this.device, '', dispatch);
                        }
                        else {
                            this.rating = amount;
                            this.$store.dashboard.set_col(this.device, data.label, dispatch);
                        }
                    },
                    currentLabel() {
                        let r = this.rating;
                        if (this.hoverRating !== this.rating) r = this.hoverRating;
                        let i = this.ratings.findIndex(e => e.amount === r);
                        if (i >=0) {return this.ratings[i].label;} else {return ''};
                    }
                }
            })

            Alpine.store('dashboard', {
                widgets: [
                    {
                        'id' : 1,
                        'col_lg': 'col-lg-3',
                        'col_md': 'col-md-3',
                        'col_sm': 'col-sm-6',
                        'col_xsm': 'col-12',
                        'view' : `
                            <div class="card text-white bg-warning bg-shining">
                                <div class="card-body">
                                    <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-user"></i></button>
                                    <div class="text-value">9.823</div>
                                    <div>کاربران</div>
                                </div>

                            </div>
                        `,
                    },
                    {
                        'id' : 2,
                        'col_lg': 'col-lg-3',
                        'col_md': 'col-md-3',
                        'col_sm': 'col-sm-6',
                        'col_xsm': 'col-12',
                        'view' : `
                            <div class="card text-white bg-success bg-shining">
                                <div class="card-body">
                                    <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-stethoscope"></i></button>
                                    <div class="text-value">9.823</div>
                                    <div>پزشکان</div>
                                </div>

                            </div>
                        `,
                    },
                    {
                        'id' : 3,
                        'col_lg': 'col-lg-3',
                        'col_md': 'col-md-3',
                        'col_sm': 'col-sm-6',
                        'col_xsm': 'col-12',
                        'view' : `<div class="card text-white bg-primary bg-shining">
                            <div class="card-body">
                                    <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-comments-o"></i></button>
                                    <div class="text-value">9.823</div>
                                    <div>گفت و گوها</div>
                                </div>
                            </div>
                        `,
                    },
                    {
                        'id' : 4,
                        'col_lg': 'col-lg-3',
                        'col_md': 'col-md-3',
                        'col_sm': 'col-sm-6',
                        'col_xsm': 'col-12',
                        'view' : `
                            <div class="card text-white bg-purple bg-shining">
                                <div class="card-body">
                                    <button class="btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-comment"></i></button>
                                    <div class="text-value">9.823</div>
                                    <div>نظرات</div>
                                </div>
                            </div>
                        `,
                    },
                    {
                        'id' : 5,
                        'col_lg': 'col-lg-6',
                        'col_md': 'col-md-6',
                        'col_sm': 'col-sm-12',
                        'col_xsm': 'col-12',
                        'view' : `
                            <div class="card text-white bg-info">
                                <div class="card-header">Card title</div>
                                <div class="card-body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</div>
                            </div>
                        `,
                    },
                ],
                active_widget_id: '',
                set_col(col, value, dispatch) {
                    const id = this.active_widget_id;
                    const index = this.widgets.findIndex((obj => obj.id == id));
                    this.widgets[index]['col_'+col] = value;
                    dispatch('widgets-updated-'+id, {
                        widget: this.widgets[index],
                    });
                }
            })


        })

        $( document ).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();


            // document.getElementsByClassName("navbar-toggler").addEventListener("click", initGrid());

            initGrid();

            function initGrid() {
                const grid = new Muuri('.grid', {
                    dragEnabled: true,
                    layoutOnInit: false,
                    dragHandle: '.handle',
                    dragContainer: document.body,
                    dragSort: function () {
                        return [grid]
                    },
                    // Layout
                    layout: {
                        fillGaps: false,
                        horizontal: false,
                        alignRight: true,
                        alignBottom: false,
                        rounding: false
                    },
                }).on('move', function () {
                    saveLayout(grid);
                });

                const layout = window.localStorage.getItem('layout');
                if (layout) {
                    loadLayout(grid, layout);
                } else {
                    grid.layout(true);
                }
            }

            function serializeLayout(grid) {
                const itemIds = grid.getItems().map(function (item) {
                    return item.getElement().getAttribute('data-id');
                });
                return JSON.stringify(itemIds);
            }

            function saveLayout(grid) {
                const layout = serializeLayout(grid);
                window.localStorage.setItem('layout', layout);
            }

            function loadLayout(grid, serializedLayout) {
                const layout = JSON.parse(serializedLayout);
                const currentItems = grid.getItems();
                const currentItemIds = currentItems.map(function (item) {
                    return item.getElement().getAttribute('data-id')
                });
                const newItems = [];
                let itemId;
                let itemIndex;

                for (let i = 0; i < layout.length; i++) {
                    itemId = layout[i];
                    itemIndex = currentItemIds.indexOf(itemId);
                    if (itemIndex > -1) {
                        newItems.push(currentItems[itemIndex])
                    }
                }

                grid.sort(newItems, {layout: 'instant'});
            }
        });

    </script>



@endsection
