@php
    $items = json_decode($widget->items);
    $col = number_format(round(12/sizeOf($items)));
    if($col < 3) $col = 3 ;
@endphp
<section class="funfacts-area pt-100">
    <div class="container">
        <div class="funfacts-inner position-relative">
            @can('page update')
                <a class="btn btn-setting mb-5" style="top:20px;right:20px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
            @endcan
            
            <div class="row">
                @foreach ($items as $item)
                <div class="col-lg-{{ $col }} col-md-{{ $col }} col-6">
                    <div class="single-funfact">
                        <div class="icon">
                            <i class='{{ $item->icon }}'></i>
                        </div>
                        <h3 style="direction: ltr;" class="odometer" data-count="{{ $item->number }}">00</h3>
                        <p>{{ $item->label }}</p>
                    </div>
                </div>
                @endforeach
                

            </div>

            <div id="particles-js-circle-bubble"></div>
        </div>
    </div>
</section>