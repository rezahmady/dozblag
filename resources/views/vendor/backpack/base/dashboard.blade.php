@extends(backpack_view('blank'))
{{-- <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.1.119/styles/kendo.bootstrap-v4.min.css"> --}}
@php
    use TorMorten\Eventy\Facades\Events as Hook;
    $widgetsArray = Hook::filter('admin-dashboard-widget::filter', []);

    $active_board_id = sizeof($widgetsArray)+1;

$x = [

        [
            'id'  => 4,
            'lg'  => 'col-lg-3',
            'md'  => 'col-md-3',
            'sm'  => 'col-sm-6',
            'xsm' => 'col-12',
            'view' => '<div class="card text-white bg-purple bg-shining">
                        <div class="card-body">
                            <button class=" btn btn-transparent p-0 float-right" type="button"><i class="la la-4x la-comment"></i></button>
                            <div class="text-value">9.823</div>
                            <div>نظرات</div>
                        </div>
                    </div>',
            'active' => true,
        ],
        [
            'id'  => 5,
            'lg'  => 'col-lg-6',
            'md'  => 'col-md-6',
            'sm'  => 'col-sm-12',
            'xsm' => 'col-12',
            'view' => '<div class="card text-white bg-info">
                        <div class=" card-header">Card title</div>
                        <div class="card-body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</div>
                    </div>',
            'active' => false,
        ],
];

@endphp

@section('content')

    <div class="position-relative" x-data="widget_layout">
        <button x-ref="editbtn" x-on:click.prevent="toggle($dispatch)" :class="edit ? 'btn btn-success setting-btn' : 'btn btn-secondary setting-btn' "   data-toggle="tooltip" data-placement="right" title="" :data-original-title="edit ? 'اتمام ویرایش' : 'شروع ویرایش' " data-style="zoom-in"><span class="ladda-label"><i class="la la-cog"></i></span></button>

        <div class="main-board muuri">
            <div class="row grid mainGrid">
                @foreach($widgetsArray as $widget)
                    @if($widget['active'])
                        <div x-data="widget('{{$widget['id']}}')" @widgets-updated-{{$widget['id']}}.window="update_class($event.detail, $dispatch)" data-id="{{$widget['id']}}" :class="columns" class="item">
                            <x-dynamic-component :component="$widget['view']" />
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="all_widgets resizable" x-show="edit">

                <div class="draggable resizer top" ><span></span></div>
                <div class="row grid archiveGrid w-100 mt-5" >
                    @foreach($widgetsArray as $widget)
                        @if(!$widget['active'])
                            <div x-data="widget('{{$widget['id']}}')" @widgets-updated-{{$widget['id']}}.window="update_class($event.detail, $dispatch)" data-id="{{$widget['id']}}" :class="columns" class="item">
                                <x-dynamic-component :component="$widget['view']" />
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>

        <div class="layout_html" x-transition x-show="layout_settings"  >
            <div class="d-flex layouts-holder bg-gray-100" x-on:click.outside="layouts_hide()">
                <template x-for="layout in layouts" :key="layout.id">
                    <div  x-data="layoutdata(layout.label)" class="d-flex ltr layout-holder">
                        <div class="d-block w-100 m-auto text-center"><i :class="layout.icon" class="la"></i></div>
                        <template x-for="star in ratings" :key="index">
                            <i class="la" @click="rate(star.amount, $dispatch)" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating"
                               aria-hidden="true"
                               class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline p-1 w-12 m-0 cursor-pointer"
                               :class="{'la-square': (rating >= star.amount || hoverRating >= star.amount), 'la-square-o': (rating < star.amount || hoverRating < star.amount) }">
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
                    toggle(dispatch) {
                        dispatch('layout-update')
                        this.edit = ! this.edit;
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
                        const data = this.$store.dashboard.widgets.find(element => element.id == this.widget_id);
                        this.columns = `${data.lg} ${data.md} ${data.sm} ${data.xsm}`
                        const tools = document.createElement('span')
                        tools.setAttribute('class', 'setting-tools');
                        tools.setAttribute('x-show', `edit`);

                        const column = document.createElement('i')
                        column.setAttribute('class', 'la la-columns');
                        column.setAttribute('x-on:click', `layouts_show('${this.widget_id}')`);

                        const move = document.createElement('i')
                        move.setAttribute('class', 'la handle la-arrows mr-2');
                        // move.setAttribute('x-on:click', `set_widget('${this.widget_id}')`);

                        tools.appendChild(move)
                        tools.appendChild(column)

                        this.$el.appendChild(tools)

                    },
                    update_class(detail, dispatch) {
                        const { widget } = detail;
                        this.columns = `${widget.lg} ${widget.md} ${widget.sm} ${widget.xsm}`;
                        dispatch('updated-class')
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
                        const data = this.ratings.find(element => element.amount === amount);
                        if (this.rating === amount) {
                            this.rating = 0;
                            Alpine.store('dashboard').set_col(this.device, '', dispatch);
                        }
                        else {
                            this.rating = amount;
                            Alpine.store('dashboard').set_col(this.device, data.label, dispatch);
                        }
                    },
                    currentLabel() {
                        let r = this.rating;
                        if (this.hoverRating !== this.rating) r = this.hoverRating;
                        let i = this.ratings.findIndex(e => e.amount === r);
                        if (i >=0) {return this.ratings[i].label;} else {return ''}
                    },
                    init() {
                        this.$watch('layout_settings', value => {
                            if(!value) {
                                this.rating = this.hoverRating = 0;
                            } else {
                                const widget = Alpine.store('dashboard').get_widget();
                                const rating = this.ratings.find(element => element.label === widget[this.device]);
                                this.rating = this.hoverRating = rating.amount;
                            }
                        })
                    }
                }
            })

            Alpine.store('dashboard', {
                widgets: @json($widgetsArray),
                active_widget_id: '',
                get_widget() {
                    const id = this.active_widget_id;
                    const index = this.widgets.findIndex((obj => obj.id === id));
                    return this.widgets[index];
                },
                set_col(col, value, dispatch) {
                    this.get_widget()[col] = value;
                    this.update_widgets();
                    dispatch('widgets-updated-'+this.active_widget_id, {
                        widget: this.get_widget(),
                    });
                },
                set_activate(status) {
                    this.get_widget()['active'] = status;
                    this.update_widgets();
                },
                update_widgets() {
                    axios.post('/admin/api/widget', {
                        widget: this.get_widget()
                    })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
            })
        })

        document.addEventListener('alpine:initialized', () => {

            const main_board = document.querySelector(".main-board");
            const itemContainers = Array.prototype.slice.call(
                main_board.querySelectorAll(".grid")
            );
            const columnGrids = [];
            let boardGrid;

            itemContainers.forEach(function(container, index) {
                const grid = new Muuri(container, {
                    dragEnabled: true,
                    layoutOnInit: false,
                    layoutOnResize: true,
                    dragHandle: '.handle',
                    dragContainer: document.body,
                    dragSort: function() {
                        return columnGrids;
                    },
                    // Layout
                    layout: {
                        fillGaps: false,
                        horizontal: false,
                        alignRight: true,
                        alignBottom: false,
                        rounding: false
                    },
                });

                initGrid(grid, index);

                const divs = document.querySelectorAll('.navbar-toggler');

                divs.forEach(el => el.addEventListener('click', event => {
                    setTimeout(function(){
                        grid.refreshItems();
                        grid.layout();
                    }, 200);
                }));

                window.addEventListener('updated-class', function (e) {
                    setTimeout(function(){
                        grid.refreshItems();
                        grid.layout();
                    }, 200);
                });

                window.addEventListener('layout-update', function () {
                    setTimeout(function(){
                        grid.refreshItems();
                        grid.layout();
                    }, 200);
                });

                columnGrids.push(grid);
            });

            function initGrid(grid, index) {

                grid.on('move', function () {
                    saveLayout(grid, index);
                });

                grid.on("dragEnd", function(item) {
                    setTimeout(function(){
                        grid.synchronize();
                        grid.refreshItems();
                        grid.layout();
                    }, 400);
                });

                grid.on('send', function (data) {
                    Alpine.store('dashboard').active_widget_id = data.item.getElement().getAttribute('data-id');
                    const status = (data.toGrid._id === 1);
                    Alpine.store('dashboard').set_activate(status);
                });

                const layout = window.localStorage.getItem('layout-'+index);
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

            function saveLayout(grid, index) {
                const layout = serializeLayout(grid);
                window.localStorage.setItem('layout-'+ index, layout);
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

            /*Make resizable div by Hung Nguyen*/
            function makeResizableDiv(div) {
                const element = document.querySelector(div);
                const resizers = document.querySelectorAll(div + ' .resizer')
                const minimum_size = 20;
                let original_width = 0;
                let original_height = 0;
                let original_x = 0;
                let original_y = 0;
                let original_mouse_x = 0;
                let original_mouse_y = 0;
                for (let i = 0;i < resizers.length; i++) {
                    const currentResizer = resizers[i];
                    currentResizer.addEventListener('mousedown', function(e) {
                        e.preventDefault()
                        original_width = parseFloat(getComputedStyle(element, null).getPropertyValue('width').replace('px', ''));
                        original_height = parseFloat(getComputedStyle(element, null).getPropertyValue('height').replace('px', ''));
                        original_x = element.getBoundingClientRect().left;
                        original_y = element.getBoundingClientRect().top;
                        original_mouse_x = e.pageX;
                        original_mouse_y = e.pageY;
                        window.addEventListener('mousemove', resize)
                        window.addEventListener('mouseup', stopResize)
                    })

                    function resize(e) {
                        if (currentResizer.classList.contains('bottom-right')) {
                            const width = original_width + (e.pageX - original_mouse_x);
                            const height = original_height + (e.pageY - original_mouse_y)
                            if (width > minimum_size) {
                                element.style.width = width + 'px'
                            }
                            if (height > minimum_size) {
                                element.style.height = height + 'px'
                            }
                        }
                        else if (currentResizer.classList.contains('bottom-left')) {
                            const height = original_height + (e.pageY - original_mouse_y)
                            const width = original_width - (e.pageX - original_mouse_x)
                            if (height > minimum_size) {
                                element.style.height = height + 'px'
                            }
                            if (width > minimum_size) {
                                element.style.width = width + 'px'
                                element.style.left = original_x + (e.pageX - original_mouse_x) + 'px'
                            }
                        }
                        else if (currentResizer.classList.contains('top-right')) {
                            const width = original_width + (e.pageX - original_mouse_x)
                            const height = original_height - (e.pageY - original_mouse_y)
                            if (width > minimum_size) {
                                element.style.width = width + 'px'
                            }
                            if (height > minimum_size) {
                                element.style.height = height + 'px'
                                element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
                            }
                        }
                        else if (currentResizer.classList.contains('top')) {
                            const height = original_height - (e.pageY - original_mouse_y)

                            if (height > minimum_size) {
                                element.style.height = height + 'px'
                                element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
                            }
                        }
                        else {
                            const width = original_width - (e.pageX - original_mouse_x)
                            const height = original_height - (e.pageY - original_mouse_y)
                            if (width > minimum_size) {
                                element.style.width = width + 'px'
                                element.style.left = original_x + (e.pageX - original_mouse_x) + 'px'
                            }
                            if (height > minimum_size) {
                                element.style.height = height + 'px'
                                element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
                            }
                        }
                    }

                    function stopResize() {
                        window.removeEventListener('mousemove', resize)
                    }
                }
            }

            makeResizableDiv('.resizable')
        })
    </script>



@endsection
