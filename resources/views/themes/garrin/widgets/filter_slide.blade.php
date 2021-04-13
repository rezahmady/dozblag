<section class="section section-specialities">
    <div class="container-fluid">
        <!-- Section Header -->
        <div class="section-header text-center position-relative">
            @can('page update')
                <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:50px;right:0;left:0;margin: auto" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            @endcan
            <h2>{{$widget->filter_title}}</h2>

        </div>
        <!-- /Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-10 col-12">
                <!-- Slider -->
                <div class="specialities-slider slider" dir="rtl">

                    @foreach ($filterItem as $item)
                    @php
                        $image = ($item->image) ? url($item->image) : '';
                    @endphp
                    <!-- Slider Item -->
                    <div class="speicality-item text-center position-relative">
                        @can('page update')
                            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:110px;left:0;z-index: 1;" href="{{ url("/admin/resource/filteritem/$item->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                        @endcan
                        <div class="speicality-img">
                            <img src="{{url($image)}}" class="img-fluid" alt="Speciality">
                        </div>
                        <p>{{$item->name}}</p>
                    </div>
                    <!-- /Slider Item --> 
                    @endforeach                                       

                </div>
                <!-- /Slider -->

            </div>
        </div>
    </div>
</section>

<script>
    window.addEventListener('contentChanged:{{$widget->name}}', event => {
        console.log('filter widget')
        if ($('.specialities-slider').length > 0) {
            $('.specialities-slider').slick({
                dots: true,
                autoplay: false,
                infinite: true,
                // variableWidth: true,
                rtl: true,
                // centerMode: true,
                slidesToShow: 5,
                slidesToScroll: 5,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '10px',
                            slidesToShow: 4
                        }
                    }, {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '20px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '20px',
                            slidesToShow: 2
                        }
                    }
                ],

                prevArrow: false,
                nextArrow: false
            });
        }
    });
</script>