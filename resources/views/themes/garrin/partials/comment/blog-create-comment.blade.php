<form wire:submit.prevent="submit">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($reply)
    <div class="row">
        <div class="col-12">
            <div class="comment-reply-holder">
                <span>در پاسخ به : <b class="comment-reply-title">{{$reply->name}}</b></span>
                <div wire:click="removeReply" class="comment-reply-close"><i class="fa fa-window-close"></i></div>
                <div class="comment-reply">
                    <p>{{$reply->body}}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="form-group">
        <label> نظر <span class="text-danger">*</span></label>
        <textarea rows="4" wire:model.defer="body" class="form-control"></textarea>
        @error('body') <span class="error">{{ $message }}</span> @enderror
    </div>

    @auth
        
    @else
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="form-group">
                <label>نام <span class="text-danger">*</span></label>
                <input type="text" wire:model.defer="name" class="form-control">
                @error('name') <span class="error">{{ $message }}</span> @enderror

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <div class="form-group">
                <label> ایمیل <span class="text-danger">*</span></label>
                <input type="email" wire:model.defer="email" class="form-control">
                @error('email') <span class="error">{{ $message }}</span> @enderror

            </div>
        </div>
    </div>
    @endauth

    <div class="submit-section">
        <button wire:loading.remove type="submit" class="button kt-modal-button button-default kt-register-button" data-modal="login">ارسال</button>
    </div>
    <div class="row">
        <div wire:loading class="loader-spiner-01"></div>
    </div>
</form>