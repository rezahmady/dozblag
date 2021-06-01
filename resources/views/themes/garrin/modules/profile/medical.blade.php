<div>		
    @if ($user->hasTemplate('doctor'))
    @endif	

 
    <!-- Basic Information -->
    <form wire:submit.prevent="submit">
        <!-- Education -->
        <div class="card position-relative">
            <div class="card-body">
                <h4 class="card-title"> پرونده پزشکی </h4>
                <div class="education-info">
                    @foreach ($medical_folder as $key => $item)
                    <div class="row form-row education-cont">
                        <div class="col-12 col-md-10 col-lg-11">
                            <div class="row form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>عنوان مدرک <span class="text-danger">*</span></label>
                                        <input wire:model.defer="medical_folder.{{$key}}.title" type="text" class="form-control">
                                        <small class="form-text text-muted">نمونه: جواب آزمایش پاتولوژی، تصویر سی تی اسکن لگن و ...</small>
                                        @error('medical_folder.'.$key.'.title') <span class="error">{{ $message }}</span> @enderror
                                    </div> 
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>تصویر مدرک <span class="text-danger">*</span></label>
                                        <div class="change-avatar">
                                            <div class="profile-img">
                                                @if (isset($photos[$key]) and is_object($photos[$key]))
                                                    <img src="{{ $photos[$key]->temporaryUrl() }}">
                                                @elseif(isset($medical_folder[$key]['photo']) and $medical_folder[$key]['photo'] != '')
                                                    <img src="{{url($medical_folder[$key]['photo'])}}">
                                                @endif
                                            </div>
                                            <div class="upload-img">
                                                <div class="change-photo-btn">
                                                    <span><i class="fa fa-upload"></i> بارگذاری تصویر </span>
                                                    <input wire:model="photos.{{$key}}" type="file" class="upload">
                                                </div>
                                                <small class="form-text text-muted">JPG ، GIF یا PNG مجاز است. حداکثر اندازه 2 مگابایت</small>
                                                @error('medical_folder.'.$key.'.photo') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group ">
                                        <label>توضیحات (اختیاری)</label>
                                        <textarea wire:model.defer="medical_folder.{{$key}}.description" class="form-control summernote" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-1" wire:click="removeRepeatableItems({{$key}}, 'medical_folder')"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="javascript:void(0);" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                    </div>
                    @endforeach

                </div>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-education" wire:click="addRepeatableItems('medical_folder')"><i class="fa fa-plus-circle"></i> افزودن مدرک</a>
                </div>
                <div  wire:loading class="loader-holder">
                    <div  class="loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- /Education -->
        
        <div class="submit-section submit-btn-bottom justify-content-end d-flex">
            <button type="submit" class="btn btn-success submit-btn">ذخیره تغییرات</button>
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

                $("#services").val(@this.get('new_services')).trigger('change');
            }
        })
    </script>

    @push('custom-style')
    @endpush
</div>
