<div class="col-lg-3 col-md-6">

    <!-- Footer Widget -->
    <div class="footer-widget footer-about position-relative">
        @can('page update')
            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-35px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        @endcan
        <div class="footer-logo">
            <img src="{{url($widget->about_img)}}" class="footer-logo" alt="logo">
        </div>
        <div class="footer-about-content">
            {!! $widget->about_description !!}

            @php
                $items = json_decode($widget->social_list);
            @endphp

            @if ($items)
            <div class="social-icon">

                <ul>

                    @foreach ($items as $item)
                    <li>
                        <a href="{{$item->link}}" target="{{$item->target}}"><i class="{{$item->icon}}"></i> </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    <!-- /Footer Widget -->

</div>