<div class="content">
    <div class="container-fluid bg-cover-06">
        
        <div class="row">
            <div class="col-md-8 offset-md-2 mb-5">
                <style>
                    .login-right .dont-have a {
                        color: #1dc9db !important;
                        font-weight: 600;
                    }
                </style>
                <!-- Login  محتوای تب -->
                <div class="account-content">
                    <div class="row align-items-center justify-content-center">
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

                            @if ($user and $step == 2)
                            <div class="login-header">
                                <h3> کد ارسالی را وارد کنید</h3>
                            </div>
                            <form wire:submit.prevent="send_code">
                                <div class="form-group form-focus">
                                    <input type="text" dir="ltr" wire:model.defer="validation_code" class="form-control floating">
                                    <label class="focus-label">کداحراز</label>
                                    @error('validation_code') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <button  wire:loading.remove class="btn btn-accept btn-block btn-lg login-btn" type="submit">‌ورود</button>
                                <div class="row">
                                    <div wire:loading class="loader-spiner-01"></div>
                                </div>
                                <div class="dont-have"><a wire:click.prevent="resetForm()" href="#">تغییر شماره</a></div>
                            </form>
                            @elseif ($user and $step == 3)
                            <div class="login-header">
                                <h3> رمز عبور جدید خود را وارد کنید</h3>
                            </div>
                            <form wire:submit.prevent="send_password">
                                <div class="form-group form-focus">
                                    <input type="password" dir="ltr" autocomplete="off" wire:model.defer="password" class="form-control floating">
                                    <label class="focus-label">رمزعبور</label>
                                    @error('password') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <button  wire:loading.remove class="btn btn-accept btn-block btn-lg login-btn" type="submit">ذخیره</button>
                                <div class="row">
                                    <div wire:loading class="loader-spiner-01"></div>
                                </div>
                            </form>
                            @elseif($step == 1)                            
                            <div class="login-header">
                                <h3> برای دریافت سریع مشاوره آنلاین پزشکی ، شماره موبایل خود را وارد کنید</h3>
                            </div>
                            <form wire:submit.prevent="send_mobile">
                                <div class="form-group form-focus">
                                    <input type="text" dir="ltr" wire:submit.prevent="send_mobile" autocomplete="new-password" wire:model.defer="mobile" class="form-control floating">
                                    <label class="focus-label">موبایل</label>
                                    @error('mobile') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <button  wire:loading.remove class="btn btn-accept btn-block btn-lg login-btn" type="submit">ارسال</button>
                                <div class="row">
                                    <div wire:loading class="loader-spiner-01"></div>
                                </div>
                                <div class="dont-have"><a wire:click.prevent="loginByPass()" href="#">ورود با رمز عبور</a></div>
                            </form>
                            @elseif($step == 4)
                            <div class="login-header">
                                <h3> برای ورود ، شماره موبایل و رمز عبور خود را وارد کنید</h3>
                            </div>
                            <form wire:submit.prevent="login">
                                <div class="form-group form-focus">
                                    <input type="text" dir="ltr" wire:model.defer="mobile" class="form-control floating">
                                    <label class="focus-label">موبایل</label>
                                    @error('mobile') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group form-focus">
                                    <input type="password" dir="ltr" wire:model.defer="password" class="form-control floating">
                                    <label class="focus-label">رمزعبور</label>
                                    @error('password') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        <div class="styled-checkbox">
                                            <input wire:model.defer="remember" type="checkbox" name="checkbox" id="remeber">
                                            <label for="remeber">مرا به خاطر بسپار</label>
                                        </div>
                                    </div>
                                </div>
                                <button  wire:loading.remove class="btn btn-accept btn-block btn-lg login-btn" type="submit">ورود</button>
                                <div class="row">
                                    <div wire:loading class="loader-spiner-01"></div>
                                </div>
                                <div class="dont-have"><a wire:click.prevent="forgetPassword()" href="#">فراموشی رمز عبور</a></div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>