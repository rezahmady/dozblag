<div>		
    @if ($user->hasTemplate('doctor'))
    @endif	

 
    <!-- Basic Information -->
    <form wire:submit.prevent="submit">
        <div class="submit-section submit-btn-bottom">
            <button type="submit" class="btn btn-primary submit-btn">ذخیره تغییرات</button>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">مشخصات اصلی</h4>
                <div class="row form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="change-avatar">
                                <div class="profile-img">
                                    @if ($photo)
                                        <img src="{{ $photo->temporaryUrl() }}">
                                    @else 
                                        <img src="{{$user->profile}}" alt="User Image">
                                    @endif
                                </div>
                                <div class="upload-img">
                                    <div class="change-photo-btn">
                                        <span><i class="fa fa-upload"></i> بارگذاری تصویر </span>
                                        <input wire:model="photo" type="file" class="upload">
                                    </div>
                                    <small class="form-text text-muted">JPG ، GIF یا PNG مجاز است. حداکثر اندازه 2 مگابایت</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> نام و نام خانوادگی <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="name" class="form-control">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>شماره تماس</label>
                            <input type="text" value="{{$user->mobile}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ایمیل<span class="text-danger"></span></label>
                            <input type="email" wire:model.defer="email"  class="form-control" >
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>جنسیت</label>
                            <select wire:model.lazy="gender" id="gender" class="form-control select">
                                <option>انتخاب</option>
                                <option @if ($gender == 'mail') selected @endif value="mail">آقا</option>
                                <option @if ($gender == 'fmail') selected @endif value="fmail">خانم</option>
                            </select>
                            @error('gender') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Information -->
        @if ($user->hasTemplate('doctor'))
        <!-- About Me -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تخصصی</h4>
                <div class="row form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>تخصص اصلی</label>
                            <select wire:model.lazy="specialty_id" id="specialty" class="form-control select"
                            x-data
                            x-ref="specialty"
                            x-init="
                            $($refs.specialty).on('select2:select', function (e) {
                                var data = $($refs.specialty).select2('val');
                                @this.set('specialty_id', data);
                            });
                            "
                            >
                                <option>-- انتخاب --</option>
                                @foreach ($filters as $key => $item)
                                    <option @if ($specialty_id == $key) selected @endif value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                            @error('specialty_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>کد نظام پزشکی <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="medical_code" class="form-control">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>تجربه (به سال) </label>
                            <input type="text" wire:model.defer="experience" class="form-control">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label>بیوگرافی</label>
                    <textarea wire:model.defer="bio" class="form-control summernote" rows="5"></textarea>
                </div>

                <div class="form-group mb-0">
                    <label>خدمات در مطب</label>
                    <div x-data="tagInput()" class="bg-grey-lighter min-h-screen">
                        <template x-for="tag in tags">
                            <input type="hidden" name="tags[]" :value="tag">
                        </template>
                    
                        <div class="max-w-sm w-full mx-auto">
                            <div class="tags-input form-control">
                                <template x-for="tag in tags" :key="tag">
                                    <span class="tags-input-tag">
                                        <span x-text="tag"></span>
                                        <button type="button" class="tags-input-remove" @click="tags = tags.filter(i => i !== tag)">
                                            &times;
                                        </button>
                                    </span>
                                </template>
                    
                                <input class="tags-input-text" placeholder="بنویسید..."
                                    @keydown.enter.prevent="if (newTag.trim() !== '') tags.push(newTag.trim()); newTag = ''"
                                    @keydown.backspace="if (newTag.trim() === '') tags.pop()"
                                    x-model="newTag"
                                >
                            </div>
                        </div>
                    </div>
                    <small class="form-text text-muted">توجه: برای افزودن خدمات جدید ، اینتر را فشار داده و وارد کنید</small>
                </div> 
            </div>
        </div>
        <!-- /About Me -->

        <!-- Contact Details -->
        <div class="card contact-card">
            <div class="card-body">
                <h4 class="card-title">جزییات تماس</h4>
                <div class="row form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>آدرس مطب</label>
                            <textarea wire:model.defer="address" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">استان</label>
                            <select id="ostan" wire:model.defer="ostan" class="form-control select"
                            x-data
                            x-ref="ostan"
                            x-init="
                            $($refs.ostan).on('select2:select', function (e) {
                                var data = $($refs.ostan).select2('val');
                                @this.set('ostan', data);
                            });
                            "
                            >
                                <option>--انتخاب استان--</option>
                                @foreach ($ostans as $key => $item)
                                    <option @if ($ostan == $key) selected @endif value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">شهرستان</label>
                            <select id="shahrestan" wire:model.defer="shahrestan"  class="form-control select"
                            x-data
                            x-ref="shahrestan"
                            x-init="
                            $($refs.shahrestan).on('select2:select', function (e) {
                                var data = $($refs.shahrestan).select2('val');
                                @this.set('shahrestan', data);
                            });
                            ">
                                @foreach ($shahrestans as $key => $item)
                                    <option @if ($shahrestan == $item) selected @endif value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- /Contact Details -->

        <!-- Education -->
        <div class="card position-relative">
            <div class="card-body">
                <h4 class="card-title"> تحصیلات </h4>
                <div class="education-info">
                    @foreach ($edu_bg as $key => $item)
                    <div class="row form-row education-cont">
                        <div class="col-12 col-md-10 col-lg-11">
                            <div class="row form-row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>مدرک</label>
                                        <input wire:model.defer="edu_bg.{{$key}}.name" type="text" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>دانشگاه/موسسه</label>
                                        <input wire:model.defer="edu_bg.{{$key}}.place" type="text" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>سال اتمام</label>
                                        <input wire:model.defer="edu_bg.{{$key}}.date" type="text" class="form-control">
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-1" wire:click="removeRepeatableItems({{$key}}, 'edu_bg')"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="javascript:void(0);" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                    </div>
                    @endforeach

                </div>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-education" wire:click="addRepeatableItems('edu_bg')"><i class="fa fa-plus-circle"></i> افزودن</a>
                </div>
                <div  wire:loading class="loader-holder">
                    <div  class="loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- /Education -->

        <!-- job -->
        <div class="card position-relative">
            <div class="card-body">
                <h4 class="card-title"> سوابق کاری </h4>
                <div class="education-info">
                    @foreach ($job_bg as $key => $item)
                    <div class="row form-row education-cont">
                        <div class="col-12 col-md-10 col-lg-11">
                            <div class="row form-row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>محل کار</label>
                                        <input wire:model.defer="job_bg.{{$key}}.name" type="text" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>زمان فعالیت</label>
                                        <input wire:model.defer="job_bg.{{$key}}.duration" type="text" class="form-control">
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-1" wire:click="removeRepeatableItems({{$key}}, 'job_bg')"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="javascript:void(0);" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                    </div>
                    @endforeach

                </div>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-education" wire:click="addRepeatableItems('job_bg')"><i class="fa fa-plus-circle"></i> افزودن</a>
                </div>
                <div  wire:loading class="loader-holder">
                    <div  class="loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- /job -->
        
        <!-- successfull -->
        <div class="card position-relative">
            <div class="card-body">
                <h4 class="card-title"> موفقیت ها </h4>
                <div class="education-info">
                    @foreach ($gif_bg as $key => $item)
                    <div class="row form-row education-cont">
                        <div class="col-12 col-md-10 col-lg-11">
                            <div class="row form-row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>تاریخ</label>
                                        <input wire:model.defer="gif_bg.{{$key}}.date" type="text" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>عنوان</label>
                                        <input wire:model.defer="gif_bg.{{$key}}.name" type="text" class="form-control">
                                    </div> 
                                </div>
                            </div>
                            <div class="row form-row">
                                <div class="col-12 col-md-6 col-lg-12">
                                    <div class="form-group">
                                        <label>توضیحات</label>
                                        <textarea wire:model.defer="gif_bg.{{$key}}.description" class="form-control" rows="3"></textarea>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-1" wire:click="removeRepeatableItems({{$key}}, 'gif_bg')"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="javascript:void(0);" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                    </div>
                    @endforeach

                </div>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-education" wire:click="addRepeatableItems('gif_bg')"><i class="fa fa-plus-circle"></i> افزودن</a>
                </div>
                <div  wire:loading class="loader-holder">
                    <div  class="loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- /successfull -->
        @endif
        
        <div class="submit-section submit-btn-bottom">
            <button type="submit" class="btn btn-primary submit-btn">ذخیره تغییرات</button>
        </div>
    </form>
    <!-- /Page Content -->

    <script>

        function tagInput() {
            return {
                tags: @entangle('services') ,
                newTag: '' 
            }
        }

        document.addEventListener('livewire:load', function () {
            $(document).ready(function() {
             
                $('#gender').on('select2:select', function (e) {
                    var data = $('#gender').select2("val");
                    @this.set('gender', data);
                });
                
            });
        })

        window.addEventListener('update-components', event => {
            if ($('.select').length > 0) {
                $('.select').select2({
                    minimumResultsForSearch: -1,
                    width: '100%'
                });
            }
        })
    </script>

    @push('custom-style')
    @endpush
</div>
