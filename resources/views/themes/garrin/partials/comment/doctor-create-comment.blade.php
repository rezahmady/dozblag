@if (!$room->comment)

    @if (session()->has('success'))
    <div class="text-center alert alert-warning" style="border-radius: 0">
        {{ session('success') }}
    </div>
    @else
    <div class="preview_holder w-100 d-block">
        
        <style>
            .fa-star {
                font-size: 20px;
                padding: 3px;
                cursor: pointer;
                color: #d8d8d8;
            }

            .text-gray-600 {
                color: #afafaf;
            }
            
            .rating-holder {
                width: max-content;
                text-align: center;
                margin:auto;
            }
            
            .fa-star.filled {
                color: #ffc107;
            }

            .comment-textarea, .rating-holder {
                background: #ecf4f7;
                border:none;
            }
            .error {
                color: #f58;
                background: #fff0f0;
                padding: 0 10px;
            }
            .loader-holder .loader-spiner-01 {
                position: absolute;
                top: 50%;
                right: 0;
                left: 0;
            }
            .loader-holder {
                right: 0;
                left: 0;
                height:100%;
                width:100%;
                background: rgb(255 255 255 / 78%);
                position: absolute;
                top: 0;
            }
        </style>
        <p class="pt-3 text-right" style="font-size: 16px;">{{ \Rezahmady\SettingOperation\Setting::get('comments.doctor-comment-info')}}</p>
        <form wire:submit.prevent="doctorSubmit" class="d-block">    
            <div class="text-right form-group">
                <label class=" d-block"> نظر <span class="text-danger">*</span></label>
                <textarea rows="3" wire:model.defer="body" class="form-control comment-textarea"></textarea>
                @error('body') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div wire:model.defer="score" class="flex items-center justify-center w-full h-screen">
                
                <div class="rating-holder d-flex w-100">
                    <div class="p-2 " style="flex-basis: 40%;">
                        <template x-if="rating || hoverRating">
                            <p class="m-0" x-text="currentLabel()"></p>
                        </template>
                        <template x-if="!rating && !hoverRating">
                            <p class="m-0">امتیاز</p>
                        </template>
                    </div>
                    <div class="m-0" dir="ltr" style="flex-basis: 60%;">
                        <template x-for="(star, index) in stars" :key="index">
                            <i class="fa fa-star"
                            @click="rate(star.amount);$dispatch('input', star.amount)" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating"
                            :class="{'text-gray-600': hoverRating >= star.amount, 'filled': rating >= star.amount && hoverRating >= star.amount}"
                            ></i>
                        </template>
                    </div>
                </div>
                <div class="p-0 text-right w-100">
                    @error('score') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-3 submit-section">
                <button wire:loading.remove type="submit" class="btn btn-success" data-modal="login">ارسال</button>
            </div>
            <div class="loader-holder" wire:loading>
                <div class="empty-chat-img loader-spiner-01"></div>
            </div>
        </form>
    </div>

    @endif
@elseif ($room->comment->status)
<div class="text-center alert alert-success" style="border-radius: 0">
    {{ \Rezahmady\SettingOperation\Setting::get('comments.doctor-success-accepted') }}
</div>
@else
<div class="text-center alert alert-warning" style="border-radius: 0">
    {{ \Rezahmady\SettingOperation\Setting::get('comments.doctor-success-created') }}
</div>
@endif