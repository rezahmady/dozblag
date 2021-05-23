<div >
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-svg-02">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <i class="fa fa-home blog-item-popular"></i>
                            <a href="{{route('resource.all')}}" rel="category" data-wpel-link="internal">بانک سلامت</a>
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{route('resource.list', ['resource' => $resource->template])}}" rel="category" data-wpel-link="internal">{{ trans('rezahmady.resource::resource.function_name.'.$resource->template)}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box" style="background: #f8f9fa" ></div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Search Filter -->
                    <div class="card search-filter">
                        <div class="card-header d-flex justify-between">
                            <h4 class="card-title font-weight-bold line-e mb-0"><i class="la la-filter"></i> فیلتر ها</h4>
                            @if ($filterShow)
                            <small class="filter-remove-btn font-weight-bold" wire:click="setNullFilterArray()">پاک کردن فیلترها</small>
                            @endif
                        </div>
                        <div class="card-body p-0">
                            
                            <div class="filter-widget p-0 mb-0" x-data="{items: true}">
                                <h4 class="font-weight-bold d-flex justify-between" x-on:click="items = !items" x-bind:class="{ 'active': items }">
                                    <span>موقعیت</span>
                                    <i class="la" x-bind:class="{'la-plus' : !items, 'la-minus' : items}"></i>
                                </h4>
                                <div class="filter-holder" x-show="items">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold">استان</label>
                                    
                                        <select id="ostan" class="form-control select">
                                            <option>-- انتخاب استان --</option>
                                            @foreach ($ostans as $key => $item)
                                                <option @if ($filter['ostan'] == $key) selected @endif value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold">شهرستان</label>
                                        <select id="shahrestan" class="form-control select">
                                            <option>-- انتخاب شهرستان --</option>
                                            @foreach ($shahrestans as $key => $item)
                                                <option @if ($filter['shahrestan'] == $item) selected @endif value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @include('theme::partials.filters')
                        </div>
                    </div>
                    <!-- /Search Filter -->

                </div>

                <div class="col-md-12 col-lg-8 col-xl-9 position-relative">

                    @if (sizeOf($items) < 1)
                        <div>
                            <h3 class="text-center p-3">رکوردی وجود ندارد</h3>
                            @if ($filterShow)
                            <small class="filter-remove-btn font-weight-bold m-auto text-center d-block" wire:click="setNullFilterArray()">پاک کردن فیلترها</small>
                            @endif
                        </div>
                    @endif
                    @foreach ($items as $item)
                    @php
                        $item = $item->withFakes();
                    @endphp
                    <!-- Doctor Widget -->
                    <div class="card" style="background-position:right">
                        <div class="card-body">
                            <div class="doctor-widget">
                                <div class="doc-info-left">
                                    <div class="">
                                        <a href="{{route('resource.show', $item->slug)}}" class="avatar avatar-xl">
                                            <img src="{{$item->getProfile()}}" class="avatar-img rounded" alt="{{ $item->name }}">
                                        </a>
                                    </div>
                                    <div class="doc-info-cont pl-3">
                                        <h4 class="doc-name">{{ $item->name }}</h4>
                                        <p class="doc-speciality">{{ $item->caption }}</p>       
                                    </div>
                                </div>
                                <div class="doc-info-right">
                                    <div class="clini-infos list-show">
                                        <ul>
                                            <li><i class="fas fa-map-marker-alt"></i>{{$item->getShahrestan()}}</li>
                                        </ul>
                                    </div>
                                    <div class="clinic-show">
                                        <a class="apt-btn" href="{{route('resource.show', $item->slug)}}">اطلاعات تماس</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Doctor Widget -->

                    @endforeach
                    <!-- Blog Pagination -->
                    <div class="row">
                        <div class="col-md-12">
                            {{ $items->links('theme::partials.pagination') }}
                        </div>
                    </div>

                    <div  wire:loading class="loader-holder">
                        <div  class="loader-spiner-01"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->

    <script> 
    // Livewire.on('$refresh', () => { }) 
    window.addEventListener('scrollToTop', event => {
        window.scrollTo({ top: 15, left: 15, behaviour: 'smooth' })
        $(document).ready(function () {
            $('#ostan').select2();
            $('#shahrestan').select2();
        })
    })

    document.addEventListener("turbolinks:load", function() {
        $(document).ready(function () {
            $('#ostan').select2();
            $('#ostan').on('select2:select', function (e) {
                var data = $('#ostan').select2('val');
                @this.set('filter.ostan', data);
            });
            $('#shahrestan').select2();
            $('#shahrestan').on('select2:select', function (e) {
                var data = $('#shahrestan').select2('val');
                @this.set('filter.shahrestan', data);
            });

            $('.filter-holder').niceScroll({
                autohidemode:'leave',
                cursorborder:'none',
                cursorcolor: '#cecece',
            });
        })
    })
    </script>
</div>