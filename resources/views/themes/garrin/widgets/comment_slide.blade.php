<section class="section home-section-comments bg-cover-05">
    <div class="container-fluid position-relative">
        @can('page update')
            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-30px;right:0;left:0;margin:auto" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        @endcan
        <!-- Section Header -->
        <div class="section-header section-comment-header position-relative text-left d-flex justify-between">
            <h2>{{$widget->comment_title}}</h2>
        </div>
        <!-- /Section Header -->

        <div class="row blog-grid-row">
            <div class="col-lg-9 col-md-12 m-auto">
                <div class="comment-slider slider" dir="rtl">
                    @php
                        $items = json_decode($widget->items);
                    @endphp

                    @foreach ($items as $item)
                    <div class="slide-holder">
                        <div class="card flex-fill rounded-3xl">
                            <div class=" p-3">
                                <h3 class="blog-title">{{$item->name}}</h3>
                                <p class="mb-0 comment-text">{!! $item->content !!}</p>
                                <div class="home-comment-rating">
                                    <span> <i class="fa fa-stethoscope pr-3"></i>مشاوره <strong>{{$item->filter}}</strong></span>
                                    <div class="rating">
                                        
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</section>

<script>
    window.addEventListener('contentChanged:{{$widget->name}}', event => {
        console.log('comments widget updated')
        if ($('.comment-slider').length > 0) {
            $('.comment-slider').slick({
                // centerMode: true,
                centerPadding: '60px',
                rtl: true,
                slidesToShow: 3,
                responsive: [{
                        breakpoint: 899,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 670,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
        }
    });
</script>