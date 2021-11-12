<section class="section section-blogs static-show mag-slider-holder">
    <div class="container-fluid">
        <!-- Section Header -->
        <div class="section-header text-left d-flex justify-between position-relative">
            @can('page update')
                <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-25px;right:0px !important;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            @endcan
            <h2><i class="{{$widget->mag_icon}} pr-3"></i>{{$widget->mag_title}}</h2>
            <div class="view-all text-right">
                <a href="{{$widget->button_link}}" class="btn btn-more">{{$widget->button_label}}</a>
            </div>
        </div>
        <!-- /Section Header -->

        @php
            $posts = Modules\Article\Models\Article::where('status', 'PUBLISHED')->latest()->get()->take(5);
        @endphp

        <div class="row blog-grid-row">
            <div class="col-md-6 col-lg-6 col-sm-12">

                <!-- Blog Post -->
                <div class="mag-slider pt-2 pb-2" dir="rtl">

                    @foreach ($posts as $item)
                    <div class="card flex-fill position-relative img-kashi-slide" style="background-image: url('{{url($item->getImage())}}');">
                        <a href="{{$item->path()}}" class="blog-content grid-blog p-3">
                            <h3 class="blog-title">{{$item->title}}</h3>
                        </a>
                        <div class="dark-gradient"></div>
                    </div>
                    @endforeach

                </div>

            </div>

            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 pt-2 pb-2">

                        <!-- Blog Post -->
                        <div class="card flex-fill position-relative img-kashi"style="background-image: url('{{url($posts[1]->image)}}');">
                            <a href="{{$posts[1]->path()}}" class="blog-content grid-blog p-3">
                                <h3 class="blog-title">{{$posts[1]->title}}</h3>
                            </a>
                            <div class="dark-gradient"></div>
                        </div>
                        <!-- /Blog Post -->

                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 pt-2 pb-2">

                        <!-- Blog Post -->
                        <div class="card flex-fill position-relative img-kashi" style="background-image: url('{{url($posts[2]->image)}}');">
                            <a href="{{$posts[2]->path()}}" class="blog-content grid-blog p-3">
                                <h3 class="blog-title">{{$posts[2]->title}}</h3>
                            </a>
                            <div class="dark-gradient"></div>
                        </div>
                        <!-- /Blog Post -->

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 pt-2 pb-2">

                        <!-- Blog Post -->
                        <div class="card flex-fill position-relative img-kashi" style="background-image: url('{{url($posts[3]->image)}}');">
                            <a href="{{$posts[3]->path()}}" class="blog-content grid-blog p-3">
                                <h3 class="blog-title">{{$posts[3]->title}}</h3>
                            </a>
                            <div class="dark-gradient"></div>
                        </div>
                        <!-- /Blog Post -->

                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 pt-2 pb-2">

                        <!-- Blog Post -->
                        <div class="card flex-fill position-relative img-kashi"style="background-image: url('{{url($posts[4]->image)}}');">
                            <a href="{{$posts[4]->path()}}" class="blog-content grid-blog p-3">
                                <h3 class="blog-title">{{$posts[4]->title}}</h3>
                            </a>
                            <div class="dark-gradient"></div>
                        </div>
                        <!-- /Blog Post -->

                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        window.addEventListener('contentChanged:{{$widget->name}}', event => {
            console.log('update doctor widget')
            if ($('.mag-slider').length > 0) {
                $('.mag-slider').slick({
                    dots: false,
                    infinite: true,
                    // fade: true,
                    prevArrow: '<button type="button" class="la-slick-prev"><i class="la la-angle-right"></i></button>',
                    nextArrow: '<button type="button" class="la-slick-next"><i class="la la-angle-left"></i></button>',
                    rtl: true,
                    autoplay: true,
                    speed: 300,
                    slidesToShow: 1,
                    adaptiveHeight: false
                });
            }
        });

        document.addEventListener("turbolinks:load", function() {
            if ($('.mag-slider').length > 0) {
                $('.mag-slider').not('.slick-initialized').slick({
                    dots: false,
                    infinite: true,
                    // fade: true,
                    prevArrow: '<button type="button" class="la-slick-prev"><i class="la la-angle-right"></i></button>',
                    nextArrow: '<button type="button" class="la-slick-next"><i class="la la-angle-left"></i></button>',
                    rtl: true,
                    autoplay: true,
                    speed: 300,
                    slidesToShow: 1,
                    adaptiveHeight: false
                });
            }
        })
    </script>

</section>
