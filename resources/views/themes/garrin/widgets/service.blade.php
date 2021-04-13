<div class="col-md-4">
    <div class="card rounded-3xl">
        <div class="card-body">
            @can('page update')
                <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:10px;right:20px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            @endcan
            <div class="info-services">
                <img src="{{$widget->service_img}}" alt="">
                <div class="text-holder">
                    <p>
                        <strong >{{$widget->service_title}}</strong>
                    </p>
                    {!! $widget->service_description !!}
                </div>
            </div>
        </div>
    </div>
</div>