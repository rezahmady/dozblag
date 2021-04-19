<section class="courses-area pt-100 pb-70">
    <div class="container">
        <div class="section-title text-left">
            <h2 class="position-relative width-max-content">{{ $widget->tabs_title }}
                @can('page update')
                       <a class="btn btn-setting mb-5" style="top:3px;left:-50px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#tb-bndy-shdh") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
                @endcan
            </h2>
            <a href="{{ $widget->tabs_button_link }}" class="default-btn">
            <i class='bx bx-show-alt icon-arrow before'></i><span class="label">{{ $widget->tabs_button_label }}</span><i class="bx bx-show-alt icon-arrow after"></i></a>
        </div>

        <div class="shorting-menu">
            
            <button class="filter" data-filter="all">همه</button>
            @foreach ($filters as $item)
            <button class="filter" data-filter=".filterItem-{{ $item->id }}">{{ $item->title }}</button>
            @endforeach
        </div>

        <div class="shorting">
            <div class="row">

                @foreach ($items as $item)

                @php
                    $fClass = "";
                    
                    foreach ($item->pages as $key => $page) {
                        $pagesId = Rezahmady\Page\Models\Page::find($page->id)->getAllParentsId();
                        foreach ($pagesId as $filterItem) {
                            $fClass .= "  filterItem-".$filterItem;
                        }
                    }
                @endphp

                <div class="col-lg-4 col-md-6 mix {{ $fClass }}">
                    <div class="single-courses-item mb-30">
                        <div class="courses-image">
                            <a href="{{ $item->path() }}" class="d-block"><img width="100%" src="{{ $item->thumb }}" alt="image"></a>
                        </div>

                        <div class="courses-content">
                            <h3><a href="{{ $item->path() }}" class="d-inline-block">{{ $item->name }}</a></h3>
                            <p>{{ $item->caption }}</p>
                        </div>

                        <div class="courses-box-footer">
                            <ul>
                                <li class="students-number">
                                    <i class='bx bx-user'></i> 10 دانشجو
                                </li>

                                <li class="courses-lesson">
                                    {{-- <i class='bx bx-book-open'></i> {{ sizeOf(json_decode($item->extras)) }} درس --}}
                                </li>

                                <li class="courses-price">
                                    رایگان
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>