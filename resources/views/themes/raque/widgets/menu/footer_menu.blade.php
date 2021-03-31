<div class="col-lg-2 col-md-6 col-sm-6 position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" style="top:-42px;right:15px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
    @endcan
    <div class="single-footer-widget mb-30">
        <h3>{{ $widget->menu_title }}</h3>
        @if ($widget->type == 'custom_menu')
            @php
                $items = json_decode(json_decode($widget->extras['data'])[0]->items);
            @endphp
            <ul class="useful-link">
                @foreach ($items as $item)
                    <li><a @isset($item->target) target="{{ $item->target }}" @endisset   @isset($item->link) href="{{ $item->link }}" @endisset  >@isset($item->label) {{ $item->label }} @endisset</a></li>
                @endforeach
            </ul>
        @else
            {!! $menu !!}
        @endif
    </div>
</div>