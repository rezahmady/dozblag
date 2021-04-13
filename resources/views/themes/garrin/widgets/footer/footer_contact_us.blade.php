<div class="col-lg-3 col-md-6">

    <!-- Footer Widget -->
    <div class="footer-widget footer-contact position-relative">
        @can('page update')
            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-35px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        @endcan
        <h2 class="footer-title">{{$widget->widget_title}}</h2>
        <div class="footer-contact-info">
            @php
                $items = json_decode($widget->contact_list);
            @endphp
            @if ($items)
                @foreach ($items as $item)
                <div class="footer-address">
                    <span><i class="{{$item->icon}}"></i></span>
                    <p>
                        @if ($item->link) <a href="{{$item->link}}" target="{{$item->link}}"> @endif
                            {{{$item->text}}}
                        @if ($item->link) </a> @endif
                    </p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- /Footer Widget -->

</div>