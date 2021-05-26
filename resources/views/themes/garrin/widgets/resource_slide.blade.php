<section class="section section-doctor">
    <div class="container-fluid">
        <!-- Section Header -->
        <div class="section-header text-left d-flex justify-between position-relative">
            @can('page update')
                <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-30px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            @endcan
            <h2>{{$widget->resource_title}}</h2>
            <div class="view-all text-right">
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
                    <div class="card card-vertical doctor-widget-holder resource-widget-holder bg-cover-03" style="background-position:right">
                        <div class="avatar avatar-xxl d-block mr-3">
                            <img src="{{$item->getProfile()}}" class="avatar-img mt-3 rounded-circle" alt="{{$item->name}}">
                        </div>
                        <div class="card-body">
                            <div class="doctor-widget mb-3">
                                <div class="doc-info-left">
                                    <div class="doc-info-cont pl-3">
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
        console.log('update doctor widget')
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