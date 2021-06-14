<div x-data="state()" x-init="init()">
    @php
        use Rezahmady\SettingOperation\Setting;
    @endphp
    <div class="modal-alpine show " x-show="modal" style="display: flow-root;background-color: rgb(88 88 88 / 50%);" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog position-relative" role="document" x-on:click.away="closeModal()">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="subscribtion.name"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span  x-on:click="closeModal()" aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="checkDiscount">
                        <div class="form-group">
                            <label class="col-form-label" for="recipient-name">کد تخفیف:</label>
                            <div class="container row">
                                <div class=" col-9">
                                    <input class="form-control" wire:model.defer="discount" id="recipient-name" type="text" data-original-title="" title="">
                                </div>
                                <button class="btn btn-primery col-3" type="submit" data-original-title="" title="">اعمال</button>
                            </div>
                            <div class="container pt-1">
                            @if ($discount_id)
                            <span class="success">کدتخفیف اعمال شد</span>
                            @endif
                            @error('discount') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <label class="col-form-label">انتخاب درگاه</label>
                        <div class="form-group gateways-holder">
                            @foreach ($gateways as $item)
                                <div class="gateways-logo" x-on:click="setDriver('{{$item}}')" :class="{ 'active': driver === '{{$item}}' }">
                                    <img src="{{asset(Setting::get("transactions.{$item}_logo"))}}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="justify-between modal-footer" style="background: aliceblue;">
                    <div>هزینه قابل پرداخت : <span x-text="getAmount()"></span></div>
                    <div>
                        <button class="btn btn-success" x-on:click="$wire.payment(subscribtion.id)" type="button" data-original-title="" title="">پرداخت</button>
                    </div>
                </div>
            </div>
            <div  wire:loading class="loader-holder">
                <div  class="loader-spiner-01"></div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-svg-02">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i><i class="fa fa-home blog-item-popular"></i>
                                <a href="{{route('doctor.list')}}" rel="category" data-wpel-link="internal">پزشکان</a>
                                <i class="fa fa-chevron-left blog-item-popular"></i>
                                <a  rel="category" data-wpel-link="internal">{{$doctor->name}}</a>
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
        <div class="container">

            

            <div class="row">
                <div class="col-md-8">
                    <div clas="card-body pt-0">

                        <!-- Doctor Widget -->
                        <div class="card card-vertical doctor-widget-holder bg-cover-06">
                            <div class="">
                                <img width="300px" src="{{$doctor->getProfile()}}" style="background: white; @if (!$doctor->profile) padding: 10px; @endif " class="img-fluid img-frame-02" alt="{{ $doctor->name }}">
                            </div>
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-right">
                                        <div class="pl-3 doc-info-cont">
                                            <h4 class="doc-name">{{ $doctor->name }}</h4>
                                            @php
                                                $path = ($doctor->speciltyFilter) ? $doctor->speciltyFilter->path() : '';
                                            @endphp
                                            <a href="{{$path}}" class="doc-speciality">{{ $doctor->getSpecilty() }}</a>
                                            <span class="pt-2 pb-3 d-block"></span>
                                            <div class="clini-infos">
                                                <ul>
                                                    <li> نظام پزشکی: <span class="value">{{$doctor->medical_code}}</span></li>
                                                    <li>تجربه: <span class="value">{{$doctor->experience}} سال</span> </li>
                                                    {{-- <li>تعداد مشاوره: <span class="value">11664 سوال (در مدت 1 سال و 10 ماه )</span> </li> --}}
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Doctor Widget -->

                        <!-- Tab Menu -->
                        <nav class="mb-4 user-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#doc_overview" data-toggle="tab"> سوابق </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#doc_locations" data-toggle="tab"> محل ها </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#doc_reviews" data-toggle="tab">نظرات</a>
                                </li>
                            </ul>
                        </nav>
                        <!-- /Tab Menu -->

                        <!--  محتوای تب -->
                        <div class="pt-0 tab-content">

                            <!-- Overview Content -->
                            <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">

                                        <!-- About Details -->
                                        <div class="widget about-widget">
                                            <h4 class="section-title"> درباره من </h4>
                                            <div class="p-3 card rounded-3xl ">
                                                {!! $doctor->bio !!}
                                            </div>
                                        </div>
                                        <!-- /About Details -->

                                        @if ($services)
                                        <!-- Services List -->
                                        <div class="service-list">
                                            <h4>خدمات در مطب</h4>
                                            <ul class="clearfix">
                                                @foreach ($services as $item)
                                                <li><a href="{{$item->path()}}">{{$item->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- /Services List -->
                                        @endif

                                        <div class="col-md-12 col-lg-9">


                                            @if ($edu_bg)
                                            <!-- Education Details -->
                                            <div class="widget education-widget">
                                                <h4 class="widget-title"> تحصیلات </h4>
                                                <div class="experience-box">
                                                    <ul class="experience-list">
                                                        @foreach ($edu_bg as $item)
                                                        <li>
                                                            <div class="experience-user">
                                                                <div class="before-circle"></div>
                                                            </div>
                                                            <div class="experience-content">
                                                                <div class="p-3 timeline-content card">
                                                                    <a href="#/" class="name"> {{$item['name']}} </a>
                                                                    <div>{{$item['place']}}</div>
                                                                    <span class="time">{{$item['date']}}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- /Education Details -->
                                            @endif

                                            @if ($job_bg)
                                            <!-- Experience Details -->
                                            <div class="widget experience-widget">
                                                <h4 class="widget-title"> کار و تجربه </h4>
                                                <div class="experience-box">
                                                    <ul class="experience-list">
                                                        @foreach ($job_bg as $item)
                                                        <li>
                                                            <div class="experience-user">
                                                                <div class="before-circle"></div>
                                                            </div>
                                                            <div class="experience-content">
                                                                <div class="p-3 timeline-content card">
                                                                    <a href="#/" class="name">{{$item['name']}}</a>
                                                                    <span class="time">{{$item['duration']}}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- /Experience Details -->
                                            @endif

                                            @if ($gif_bg)
                                            <!-- Awards Details -->
                                            <div class="widget awards-widget">
                                                <h4 class="widget-title">جایزه ها</h4>
                                                <div class="experience-box">
                                                    <ul class="experience-list">
                                                        @foreach ($gif_bg as $item)
                                                        <li>
                                                            <div class="experience-user">
                                                                <div class="before-circle"></div>
                                                            </div>
                                                            <div class="experience-content">
                                                                <div class="p-3 timeline-content card">
                                                                    <p class="exp-year">{{$item['date']}}</p>
                                                                    <h4 class="exp-title">{{$item['name']}}</h4>
                                                                    <p>{{$item['description']}}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- /Awards Details -->
                                            @endif

                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!-- /Overview Content -->

                            <!-- Locations Content -->
                            <div role="tabpanel" id="doc_locations" class="tab-pane fade">
                                @if ($clinics)
                                    @foreach ($clinics as $item)
                                    <!-- Location List -->
                                    <div class="p-3 location-list card bg-cover-05">
                                        <div class="doc-info-left">
                                            <div class="">
                                                <a href="{{route('resource.show', $item->slug)}}" class="avatar avatar-xl">
                                                    <img src="{{$item->getProfile()}}" class="rounded avatar-img" alt="{{ $item->name }}">
                                                </a>
                                            </div>
                                            <a href="{{route('resource.show', $item->slug)}}" class="pl-3 doc-info-cont">
                                                <h4 class="doc-name">{{ $item->name }}</h4>
                                                <p class="doc-speciality">{{ $item->caption }}</p>       
                                            </a>
                                        </div>
                                    </div>
                                    <!-- /Location List -->
                                    @endforeach
                                @endif


                            </div>
                            <!-- /Locations Content -->

                            <!-- Reviews Content -->
                            <div role="tabpanel" id="doc_reviews" class="tab-pane fade">

                                <!-- Review Listing -->
                                <livewire:comment.comment-holder :module="$doctor" :view="'theme::partials.comment.doctor-comments'"/>
                                <!-- /Review Listing -->
                            </div>
                            <!-- /Reviews Content -->

                        </div>
                    </div>


                </div>
                <div class="col-md-4">
                    @if (auth()->check() and backpack_user()->getRoom($doctor->id))
                    <div class="widget about-widget position-relative">
                        <div class="p-3 card bg-cover-09">
                            <h4 class="section-title"> مشاوره </h4>
                            <p>
                                می توانید از اینجا وارد گفت و گو با پزشک شوید
                            </p>
                            
                            <a class="apt-btn consulation-btn" target="_blank" href="{{ route('chatyno.show', backpack_user()->getRoomMd5Id($doctor->id)) }}" >گفت و گوی متنی با پزشک <i class="la la-angle-left"></i></a>
                        </div>

                        <div  wire:loading class="loader-holder">
                            <div  class="loader-spiner-01"></div>
                        </div>
                    </div>
                    @else
                    <!-- About Details -->
                    <div class="widget about-widget position-relative">
                        <div class="p-3 card bg-cover-09">
                            <h4 class="section-title"> پلن های مشاوره </h4>
                            <p>
                                یکی از پلن های زیر را انتخاب کنید
                            </p>
                            
                            @foreach ($packages as $item)
                            <div class="subscribtion-card flex-fill @if ($item->id == $subscribtion['id']) active @endif"
                                x-on:click="@this.selectSubscribtion({{$item->id}})"
                                >
                                <div class="subscribtion-card-body">
                                    <div class="justify-between d-flex">
                                        <h5 class="card-title fw-800">{{$item->name}}</h5>
                                        <div class="subscribtion-custom">
                                            @if ($item->extras->amount_before_discount)
                                            <span class="price-strike">{{number_format($item->extras->amount_before_discount)}} تومان</span>
                                            @endif
                                            <span class="price">{{number_format($item->amount)}} تومان</span>
                                        </div>

                                    </div>
                                    {!! $item->description !!}
                                </div>
                            </div>
                            @endforeach
                            <a class="apt-btn consulation-btn" href="javascript:void(0);" x-on:click="openModal()"  data-toggle="modal" data-target="#exampleModalmdo"  tabindex="0">شروع گفت و گوی متنی با پزشک <i class="la la-angle-left"></i></a>
                        </div>

                        <div  wire:loading class="loader-holder">
                            <div  class="loader-spiner-01"></div>
                        </div>
                    </div>
                    <!-- /About Details -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <script>
        function state() {
            return {
                // widget: @entangle('widget'),
                driver: @entangle('driver'),
                subscribtion: @entangle('subscribtion'),
                modal: false,
                modal_name: '',
                modal_id: '',
                setDriver(driver) {
                    this.driver = driver
                },
                getAmount() {
                    return (new Intl.NumberFormat('fa-IR', { maximumSignificantDigits: 3 }).format(this.subscribtion.amount));
                },
                openModal() {
                    this.modal = true;
                },
                closeModal() {
                    this.modal = false;
                },
                init() {
                    $(document).on('lity:close', function(event, instance) {
                        setTimeout(() => {
                            Livewire.emit('update-widget');
                        }, 1500)
                    });
                },
            }
        }
    </script>

</div>
