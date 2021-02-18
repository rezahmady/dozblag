<section class="courses-categories-area pb-70" style="position: relative;">
    <div class="container" >
        <div class="section-title text-left">
            
            <h2 class="position-relative width-max-content">{{ $widget->category_title }}
                
                @can('page update')
                       <a data-lity class="btn btn-setting mb-5" style="top:3px;left:-50px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#dsth-bndy-dorh-ha") }}" ><i wire:loading.class="loader" class="bx bx-cog "></i></a>
                @endcan
            </h2>
            <a href="{{ $widget->category_button_link }}" class="default-btn"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">{{ $widget->category_button_label }}</span><i class="bx bx-show-alt icon-arrow after"></i></a>
        </div>

        
        <div class="courses-categories-slides row">

            @foreach ($categories as $item)
            <div class="col-md-3 col-sm-4 col-6 ">
                <div class="single-categories-courses-item mb-30 ">
                    <image src="{{ asset($item->extras['image']) }}" style="
                        position: absolute;
                        width: 100%;
                        right: 0;
                        left: 0;
                        top: 0;
                        bottom: 0;
                        z-index: -1;
                    " >
                    <div class="icon">
                        <i class='bx bx-layer'></i>
                    </div>
                    <h3>{{ $item->name }}</h3>
                    {{-- <span>58 دوره آموزش</span> --}}
    
                    <a href="{{ $item->path() }}" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>
    
                    <a href="{{ $item->path() }}" class="link-btn"></a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <div class="loader-bg">
        <div class="loader"></div>
    </div>


    <div id="particles-js-circle-bubble-2"></div>
</section>