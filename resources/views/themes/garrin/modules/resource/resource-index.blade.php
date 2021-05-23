<div>
@php
use Rezahmady\SettingOperation\Setting;
@endphp
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-svg-02">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i><i class="fa fa-home blog-item-popular"></i>
                                <a rel="category" data-wpel-link="internal">بانک سلامت</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box" style="background: #f8f9fa" ></div>
    @foreach ($templates as $key => $items)
    <section class="section section-doctor">
        <div class="container-fluid">
            <!-- Section Header -->
            <div class="col-lg-12">
                <div class="section-header text-left d-flex justify-between">
                    <h4 class="font-weight-bold">{{Setting::get("resources.template_{$key}_title") ?? $resources[$key]}}</h4>
                    <a href="{{url('/resource/'.$key)}}">مشاهده همه</a>
                </div>
            </div>
            <!-- /Section Header -->
            <div class="col-lg-12">
                <div class="resource-slider slider" dir="rtl">

                    @foreach ($items as $item)
                    <!-- Doctor Widget -->
                    <div class="card card-vertical doctor-widget-holder" width="240px">
                        <div class="avatar avatar-xxl d-block m-auto">
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
                    <!-- /Doctor Widget -->
                    @endforeach
    
                </div>
            </div>
        </div>
    </section>
    @endforeach
    
    <script>
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
</div>