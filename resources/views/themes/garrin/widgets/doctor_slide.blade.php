<section class="section section-doctor">
    <div class="container-fluid">
        <!-- Section Header -->
        <div class="section-header text-left position-relative">
            @can('page update')
                <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-30px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            @endcan
            <h2><i class="{{$widget->doctor_icon}} pr-3"></i>{{$widget->doctor_title}}</h2>
            <p class="sub-title">{!! $widget->doctor_description !!}</p>

        </div>
        <!-- /Section Header -->
        <div class="">

            <div class="col-lg-12">
                <div class="doctor-slider slider" dir="rtl">

                    @foreach ($users as $item)
                    <!-- Doctor Widget -->
                    <div class="card card-vertical doctor-widget-holder bg-cover-08 home-widget">
                        @can('page update')
                            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:10px;left:0;" href="{{ url("/admin/user/$item->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                        @endcan
                        <div class="">
                            <img src="{{$item->profile}}" class="img-fluid img-frame-02 " alt="User Image">
                        </div>
                        <div class="card-body">
                            <div class="doctor-widget mb-3">
                                <div class="doc-info-left">
                                    <div class="doc-info-cont pl-3">
                                        <h4 class="doc-name">{{$item->name}}</h4>
                                        <p class="doc-speciality">{{$item->getSpecilty()}}</p>
                                    </div>
                                </div>
                    
                            </div>
                            <a class="apt-btn" href="{{$item->getPageLink()}}">گفتگوی متنی با پزشک</a>
                        </div>
                    </div>
                    <!-- /Doctor Widget -->
                    @endforeach
    
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    window.addEventListener('contentChanged:{{$widget->name}}', event => {
        console.log('update doctor widget')
        if ($('.doctor-slider').length > 0) {
            $('.doctor-slider').slick({
                dots: false,
                autoplay: false,
                infinite: true,
                rtl: true,
                // centerMode: true,
                variableWidth: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 4
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
        }
    });
</script>