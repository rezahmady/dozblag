<div class="copyright-menu  position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-35px;left:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
    @endcan
    @if ($widget->type == 'custom_menu')
            @php
                $items = json_decode(json_decode($widget->extras['data'])[0]->items);
            @endphp
            <ul class="policy-menu">
                @foreach ($items as $item)
                    <li><a @isset($item->target) target="{{ $item->target }}" @endisset   @isset($item->link) href="{{ $item->link }}" @endisset  >@isset($item->label) {{ $item->label }} @endisset</a></li>
                @endforeach
            </ul>
        @else
            {!! $menu !!}
        @endif
</div>