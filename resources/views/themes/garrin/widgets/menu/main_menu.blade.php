<div>
    <ul class="main-nav position-relative">
        @can('page update')
            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-6px;left:-50px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        @endcan

        @if ($widget->type == 'custom_menu')
            @php
                $items = json_decode(json_decode($widget->extras['data'])[0]->items);
            @endphp

            @foreach ($items as $item)
                <li class="nav-item"><a @isset($item->target) target="{{ $item->target }}" @endisset   @isset($item->link) href="{{ $item->link }}" @endisset  >@isset($item->label) {{ $item->label }} @endisset</a></li>
            @endforeach
        @else
            {!! $menu !!}
        @endif

    </ul>

    <script>


        document.addEventListener("turbolinks:load", function() {
            // Sidebar

            $( document ).ready(function() {
                if ($(window).width() <= 991) {
                    var Sidemenu = function() {
                        this.$menuItem = $('.main-nav a');
                    };

                    function init() {
                        var $this = Sidemenu;
                        $('.main-nav a').on('click', function(e) {
                            if ($(this).parent().hasClass('has-submenu')) {
                                e.preventDefault();
                            }
                            if (!$(this).hasClass('submenu')) {
                                $('ul', $(this).parents('ul:first')).slideUp(350);
                                $('a', $(this).parents('ul:first')).removeClass('submenu');
                                $(this).next('ul').slideDown(350);
                                $(this).addClass('submenu');
                            }
                            //  else if ($(this).hasClass('submenu')) {
                            //     $(this).removeClass('submenu');
                            //     $(this).next('ul').slideUp(350);
                            // }
                        });
                    }

                    // Sidebar Initiate
                    init();
                }
            });

        })
    </script>
</div>
