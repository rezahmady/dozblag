<div x-data="state()" x-init="init()">
    @php
        use Rezahmady\SettingOperation\Setting;
    @endphp
    <div class="modal-alpine show " x-show="modal" style="display: flow-root;background-color: rgb(88 88 88 / 50%);" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  position-relative" role="document" x-on:click.away="closeModal()">
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
                <div class="modal-footer justify-between" style="background: aliceblue;">
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
                                <img width="300px" src="{{$doctor->getProfile()}}" class="img-fluid img-frame-02" alt="User Image">
                            </div>
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-right">
                                        <div class="doc-info-cont pl-3">
                                            <h4 class="doc-name">{{ $doctor->name }}</h4>
                                            <p class="doc-speciality">{{ $doctor->getSpecilty() }}</p>
                                            <span class="pb-3 pt-2 d-block"></span>
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
                        <nav class="user-tabs mb-4">
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
                        <div class="tab-content pt-0">

                            <!-- Overview Content -->
                            <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">

                                        <!-- About Details -->
                                        <div class="widget about-widget">
                                            <h4 class="section-title"> درباره من </h4>
                                            <div class="card p-3 rounded-3xl ">
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
                                                                <div class="timeline-content card p-3">
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
                                                                <div class="timeline-content card p-3">
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
                                                                <div class="timeline-content card p-3">
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
                                    <div class="location-list card p-3 bg-cover-05">
                                        <div class="row">

                                            <!-- Clinic Content -->
                                            <div class="col-md-6">
                                                <div class="clinic-content">
                                                    <h4 class="clinic-name"><a href="#">{{$item->name}}</a></h4>
                                                    <p class="doc-speciality">{{$item->caption}}</p>
                                                    {{-- <div class="rating">
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star filled"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span class="d-inline-block average-rating">(4)</span>
                                                    </div> --}}
                                                    <div class="clinic-details mb-0">
                                                        <h5 class="clinic-direction"> <i class="fas fa-map-marker-alt"></i> {{$item->address}}</a></h5>
                                                        <ul>
                                                            <li>
                                                                <a href="assets/img/features/feature-01.jpg" data-fancybox="gallery2">
                                                                    <img src="/assets/garrin/img/features/feature-01.jpg" alt="Feature Image">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="assets/img/features/feature-02.jpg" data-fancybox="gallery2">
                                                                    <img src="/assets/garrin/img/features/feature-02.jpg" alt="Feature Image">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="assets/img/features/feature-03.jpg" data-fancybox="gallery2">
                                                                    <img src="/assets/garrin/img/features/feature-03.jpg" alt="Feature Image">
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="assets/img/features/feature-04.jpg" data-fancybox="gallery2">
                                                                    <img src="/assets/garrin/img/features/feature-04.jpg" alt="Feature Image">
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Clinic Content -->

                                            <!-- Clinic Timing -->
                                            <div class="col-md-6">
                                                @php
                                                    $options = json_decode($item->options);
                                                @endphp
                                                @if ($options)
                                                <div class="clinic-timing">
                                                    @foreach ($options as $option)
                                                    <div>
                                                        <p class="timings-days">
                                                            <span>{{$option->day}}</span>
                                                        </p>
                                                        <p class="timings-times">
                                                            <span>{{$option->start}} - {{$option->end}}</span>
                                                        </p>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                            <!-- /Clinic Timing -->

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
                                <div class="widget review-listing">
                                    <ul class="comments-list">

                                        <!-- Comment List -->
                                        <li>
                                            <div class="comment card p-3">
                                                <div class="comment-body">
                                                    <div class="meta-data">
                                                        <img class="avatar avatar-sm rounded-circle comment-avatar" alt="User Image" src="/assets/garrin/img/patients/patient.jpg">
                                                        <div class="inline-block">
                                                            <span class="comment-author">ریچارد ویلسون</span>
                                                            <span class="comment-date">نظر داده شده 2 روز پیش</span>
                                                        </div>
                                                        <div class="review-count rating">
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p class="comment-content">
                                                        سادگی نام چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط کاربردی می باشد
                                                    </p>

                                                </div>
                                            </div>
                                        </li>
                                        <!-- /Comment List -->

                                        <!-- Comment List -->
                                        <li>
                                            <div class="comment card p-3">
                                                <div class="comment-body">
                                                    <div class="meta-data">
                                                        <img class="avatar avatar-sm rounded-circle comment-avatar" alt="User Image" src="/assets/garrin/img/patients/patient2.jpg">
                                                        <div class="inline-block">
                                                            <span class="comment-author">تراویس تریمبل</span>
                                                        <span class="comment-date">نظر داده شده 4 روز پیش</span>
                                                        </div>
                                                        <div class="review-count rating">
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p class="comment-content">
                                                        سادگی نام چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط کاربردی می باشد
                                                    </p>

                                                </div>
                                            </div>
                                        </li>
                                        <!-- /Comment List -->

                                        <!-- Comment List -->
                                        <li>
                                            <div class="comment card p-3">
                                                <div class="comment-body">
                                                    <div class="meta-data">
                                                        <img class="avatar avatar-sm rounded-circle comment-avatar" alt="User Image" src="/assets/garrin/img/patients/patient2.jpg">
                                                        <div class="inline-block">
                                                            <span class="comment-author">تراویس تریمبل</span>
                                                        <span class="comment-date">نظر داده شده 4 روز پیش</span>
                                                        </div>
                                                        <div class="review-count rating">
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p class="comment-content">
                                                        سادگی نام چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط کاربردی می باشد
                                                    </p>

                                                </div>
                                            </div>
                                        </li>
                                        <!-- /Comment List -->

                                        <!-- Comment List -->
                                        <li>
                                            <div class="comment card p-3">
                                                <div class="comment-body">
                                                    <div class="meta-data">
                                                        <img class="avatar avatar-sm rounded-circle comment-avatar" alt="User Image" src="/assets/garrin/img/patients/patient2.jpg">
                                                        <div class="inline-block">
                                                            <span class="comment-author">تراویس تریمبل</span>
                                                        <span class="comment-date">نظر داده شده 4 روز پیش</span>
                                                        </div>
                                                        <div class="review-count rating">
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p class="comment-content">
                                                        سادگی نام چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط کاربردی می باشد
                                                    </p>

                                                </div>
                                            </div>
                                        </li>
                                        <!-- /Comment List -->

                                        <!-- Comment List -->
                                        <li>
                                            <div class="comment card p-3">
                                                <div class="comment-body">
                                                    <div class="meta-data">
                                                        <img class="avatar avatar-sm rounded-circle comment-avatar" alt="User Image" src="/assets/garrin/img/patients/patient2.jpg">
                                                        <div class="inline-block">
                                                            <span class="comment-author">تراویس تریمبل</span>
                                                        <span class="comment-date">نظر داده شده 4 روز پیش</span>
                                                        </div>
                                                        <div class="review-count rating">
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star filled"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <p class="comment-content">
                                                        سادگی نام چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط کاربردی می باشد
                                                    </p>

                                                </div>
                                            </div>
                                        </li>
                                        <!-- /Comment List -->

                                    </ul>

                                    <!-- Show All -->
                                    <div class="all-feedback text-center">
                                        <a href="#" class="btn btn-primary btn-sm">
                                            نمایش همگی فیدبک ها <strong>(167)</strong>
                                        </a>
                                    </div>
                                    <!-- /Show All -->

                                </div>
                                <!-- /Review Listing -->
                            </div>
                            <!-- /Reviews Content -->

                        </div>
                    </div>


                </div>
                <div class="col-md-4">
                    @if (backpack_user()->getRoom($doctor->id))
                    <div class="widget about-widget position-relative">
                        <div class="card p-3 bg-cover-09">
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
                        <div class="card p-3 bg-cover-09">
                            <h4 class="section-title"> پلن های مشاوره </h4>
                            <p>
                                یکی از پلن های زیر را انتخاب کنید
                            </p>
                            
                            @foreach ($packages as $item)
                            <div class="subscribtion-card flex-fill @if ($item->id == $subscribtion['id']) active @endif"
                                x-on:click="@this.selectSubscribtion({{$item->id}})"
                                >
                                <div class="subscribtion-card-body">
                                    <div class="d-flex justify-between">
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
