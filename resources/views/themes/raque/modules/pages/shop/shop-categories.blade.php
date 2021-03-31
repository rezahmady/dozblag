<div>
    <!-- Start Page Title Area -->
    <livewire:partials.page :page="$data['page']" :view="'theme::partials.shop_page_header'" />
    <!-- End Page Title Area -->

    <!-- Start Courses Area -->
    <section class="courses-categories-area ptb-100">
        <div class="container">
            <div class="row">

                @foreach ($data['children'] as $item)
                @php
                    $icon = ($item->icon) ? $item->icon : 'bx bx-layer'
                @endphp
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

                
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {{ $data['children']->links('theme::partials.pagination') }}
                </div>
            </div>
        </div>

        <div id="particles-js-circle-bubble-2"></div>
    </section>
    <!-- End Courses Area -->
</div>