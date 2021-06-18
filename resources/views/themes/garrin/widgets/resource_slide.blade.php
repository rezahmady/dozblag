<section class="section section-doctor">
    <div class="container-fluid">
        <!-- Section Header -->
        <div class="justify-between text-left section-header d-flex position-relative">
            @can('page update')
                <a class="mb-5 btn btn-setting" x-on:click="setwidget('{{$widget->name}}')" style="top:-30px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            @endcan
            <h2>{{$widget->resource_title}}</h2>
            <div class="text-right view-all">
                <a href="{{$widget->button_link}}" class="btn btn-more">{{$widget->button_label}}</a>
            </div>
        </div>
        <!-- /Section Header -->
        <div class="">
            @php
                $resources = Rezahmady\Resource\Models\Resource::take(10)->get();
            @endphp

            <div class="col-lg-12">
                <div class="resource-slider slider" dir="rtl">

                    @foreach ($resources as $item)
                    <!-- Resource Widget -->
                    <div class="card card-vertical doctor-widget-holder resource-widget-holder bg-cover-03 bg-position-right">
                        <div class="mr-3 avatar avatar-xxl d-block">
                            <img src="{{$item->getProfile()}}" class="mt-3 avatar-img rounded-circle" alt="{{$item->name}}">
                        </div>
                        <div class="card-body">
                            <div class="mb-3 doctor-widget">
                                <div class="doc-info-left">
                                    <div class="pl-3 doc-info-cont">
                                        <h4 class="doc-name">{{$item->name}}</h4>
                                        <p class="doc-speciality">{{$item->caption}}</p>
                                    </div>
                                </div>
                    
                            </div>
                            <div class="clinic-show">
                                <a class="apt-btn" href="{{route('resource.show', $item->slug)}}">اطلاعات تماس</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Resource Widget -->
                    @endforeach
    
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    window.addEventListener('contentChanged:{{$widget->name}}', event => {
        $('.resource-slider').slick({
            dots: false,
            autoplay: false,
            infinite: true,
            rtl: true,
            // centerMode: true,
            variableWidth: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 928,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ],
        });
    });

    document.addEventListener("turbolinks:load", function() {
        $('.resource-slider').slick({
            dots: false,
            autoplay: false,
            infinite: true,
            rtl: true,
            // centerMode: true,
            variableWidth: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 928,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ],
        });
    })
</script>