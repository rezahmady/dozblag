<ul class="navbar-nav position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" style="top:24px;right:-35px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
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