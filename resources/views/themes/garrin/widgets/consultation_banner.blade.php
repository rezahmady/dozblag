<section class="section section-blogs section-banner-01">
    <div class="container-fluid">
        <div class="banner-holder d-flex bg-cover-08" >
            <div class="row">
                <div class="section-header text-left col-md-8 col-sm-6 col-12 position-relative">
                    @can('page update')
                        <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:18px;right:15px !important;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                    @endcan
                    <h2>{{$widget->banner_title}}</h2>
                    <p class="sub-title">{!! $widget->banner_description !!}</p>
                    <a href="{{$widget->button_link}}" class="btn btn-cosulotion">{{$widget->button_label}} <i class="fa fa-angle-left pl-3"></i></a>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <img src="{{url($widget->banner_img)}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>