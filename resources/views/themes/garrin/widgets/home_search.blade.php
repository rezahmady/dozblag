<section class="section section-search">
    <div class="container-fluid d-flex">
        <div class="col-md-8 col-lg-8 col-12">
            <div class="banner-wrapper">
                <div class="banner-header text-center position-relative">
                    @can('page update')
                        <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:10px;right:20px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                    @endcan
                    <h1>{{$widget->search_title}}</h1>
                    <p>{{$widget->search_description}}</p>
                </div>

                <!-- Search -->
                <div class="search-box">
                    <form action="/template-rtl/search.html">
                        <div class="form-group search-info">
                            <input type="text" class="form-control" placeholder="{{$widget->input_placeholder}}">
                            <span class="form-text">{{$widget->input_hint}}</span>
                        </div>
                        <button type="submit" class="btn btn-accept search-btn"><i class="fas fa-search"></i> <span>جستجو</span></button>
                    </form>
                </div>
                <!-- /Search -->

            </div>
        </div>

        <div class="col-md-4 col-lg-4 col-12 d-none d-lg-block d-md-block">
            <img src="{{url($widget->header_img)}}" width="100%" alt="">
        </div>
    </div>
</section>