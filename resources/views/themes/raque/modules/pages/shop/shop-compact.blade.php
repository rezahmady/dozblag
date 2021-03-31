<div>
    <!-- Start Page Title Area -->
    <livewire:partials.page :page="$data['page']" :view="'theme::partials.shop_page_header'" />
    <!-- End Page Title Area -->

    <!-- Start Courses Area -->
    <section class="courses-area ptb-100">
        <div class="container">
            <div class="courses-topbar">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4">
                        
                    </div>

                    <div class="col-lg-8 col-md-8">
                        <div class="topbar-ordering-and-search">
                            <div class="row ">
                                @php
                                    $filters = App\Models\Filter::where('status', 1)->get();
                                @endphp

                                @foreach ($filters as $filter)

                                {{-- <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="topbar-ordering">
                                        <select wire:model="filterItem">
                                            @foreach ($filter->items->pluck('name', 'id') as $id => $item)
                                                
                                            <option value="{{ $id }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                @endforeach

                                {{-- <div class="col-lg-5 col-md-6 col-sm-6">
                                    <div class="topbar-search">
                                        <form>
                                            <label><i class="bx bx-search"></i></label>
                                            <input wire:model="search" type="text" value="{{ $search }}" key="search-box" class="input-search" placeholder="جستجو ...">
                                        </form>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($data['items'] as $item)
                <div class="col-lg-4 col-md-6">
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
                                {{-- <li class="students-number">
                                    <i class='bx bx-user'></i> 10 دانشجو
                                </li> --}}

                                <li class="courses-lesson">
                                    {{-- <i class='bx bx-book-open'></i> {{ sizeOf(json_decode($item->extras)) }} درس --}}
                                </li>

                                {{-- <li class="courses-price">
                                    مشاهده
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-lg-12 col-md-12 col-sm-12">
                    {{ $data['items']->links('theme::partials.pagination') }}
                </div>
            </div>
        </div>
    </section>
    <!-- End Courses Area -->
</div>