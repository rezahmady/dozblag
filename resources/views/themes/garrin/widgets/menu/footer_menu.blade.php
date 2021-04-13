<div class="col-lg-3 col-md-6">

    <!-- Footer Widget -->
    <div class="footer-widget footer-menu position-relative">
        @can('page update')
            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-35px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        @endcan
        <h2 class="footer-title">{{$widget->menu_title}}</h2>

        @if ($widget->type == 'custom_menu')
            @php
                $items = json_decode(json_decode($widget->extras['data'])[0]->items);
            @endphp
            <ul>
                @foreach ($items as $item)
                    <li><a @isset($item->target) target="{{ $item->target }}" @endisset   @isset($item->link) href="{{ $item->link }}" @endisset  >@isset($item->label) {{ $item->label }} @endisset</a></li>
                @endforeach
            </ul>
        @else
            {!! $menu !!}
        @endif
    </div>
    <!-- /Footer Widget -->

</div>