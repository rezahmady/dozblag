<div class="col-md-12 col-lg-6 login-right login-holder rounded-3xl">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="login-header">
        <h3> کد ارسالی را وارد کنید</h3>
    </div>
    <form wire:submit.prevent="submit">
        <div class="form-group form-focus">
            <input type="text" dir="ltr" wire:model.defer="validation_code" class="form-control floating">
            <label class="focus-label">کدفعال سازی</label>
            @error('validation_code') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button  wire:loading.remove class="btn btn-accept btn-block btn-lg login-btn" type="submit">‌ورود</button>
        <div class="row">
            <div wire:loading class="loader-spiner-01"></div>
        </div>
        <div class="dont-have"><a wire:click="resetForm()" href="#">تغییر شماره</a></div>
    </form>
</div>