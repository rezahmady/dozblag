<div class="col-lg-4 col-md-6 col-sm-6 position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" style="top:-42px;right:15px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
    @endcan
    <div class="single-footer-widget mb-30">
        <h3>{{ $widget->widget_title}}</h3>

        @php
            $contacts = json_decode($widget->contact_list);
        @endphp

        <ul class="contact-us-link">
        @foreach ($contacts as $item)
            <li>
                <i class='{{$item->icon}}'></i>
                <a href="{{ $item->link }}" target="{{ $item->target }}">{{ $item->text }}</a>
            </li>
        @endforeach
            
        </ul>

        @php
            $social = json_decode($widget->social_list);
        @endphp

        <ul class="social-link">
            @foreach ($social as $item)
                <li><a href="{{ $item->link }}" class="d-block" target="{{ $item->target }}"><i class='{{ $item->icon }}'></i></a></li>
            @endforeach
        </ul>
    </div>
</div>
