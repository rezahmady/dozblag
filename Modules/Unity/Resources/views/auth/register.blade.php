@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8">
            <h3 class="text-center mb-4">{{ trans('backpack::base.register') }}</h3>
            <div class="card">
                <div class="card-body">
                    <form class=" p-t-10" role="form" method="POST" action="{{ route('unity.auth.register') }}">
                        {!! csrf_field() !!}

                        <div>
                            <h4 class="title">شرکت</h4>
                            <span>مشخصات حقوقی شرکت را با دقت وارد کنید</span>
                            <hr>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group required">
                                <label class="control-label" for="fa_name">عنوان فارسی شرکت</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- <i class="la la-pencil-square la-lg"></i> -->
                                            شرکت حمل و نقل بین المللی
                                        </span>
                                    </div>         
                                    <input type="text" name="fa_name" placeholder="عنوان واحد را اینجا بنویسید" class="form-control {{ $errors->has('fa_name') ? ' is-invalid' : '' }} form-control-lg" value="{{ old('fa_name') }}">
                                </div>
                                @if ($errors->has('fa_name'))
                                    <span class="invalid-feedback  d-block">
                                        <strong>{{ $errors->first('fa_name') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group col-md-12 text-left required" element="div" bp-field-wrapper="true" bp-field-name="en_name" bp-field-type="text">
                                <label>عنوان انگلیسی شرکت</label>
    
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">INTL TRP CO</span></div>
                                    <input type="text" name="en_name" placeholder="Unity title" class="form-control{{ $errors->has('en_name') ? ' is-invalid' : '' }} form-control-lg text-left" value="{{ old('en_name') }}">
                                    <div class="input-group-append"><span class="input-group-text"><i class="la la-pencil-square la-lg"></i></span></div>
                                </div> 
    
                                @if ($errors->has('en_name'))
                                    <span class="invalid-feedback  d-block">
                                        <strong>{{ $errors->first('en_name') }}</strong>
                                    </span>
                                @endif
                            </div>
    

                            <div class="form-group col-md-12 required" element="div" bp-field-wrapper="true" bp-field-name="fa_address" bp-field-type="summernote">
                                <label>آدرس فارسی شرکت</label>
                                <textarea name="fa_address" class="form-control{{ $errors->has('fa_address') ? ' is-invalid' : '' }} summernote">{{ old('fa_address') }}</textarea>
                                @if ($errors->has('fa_address'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('fa_address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-12 required">
                                <label >آدرس انگلیسی شرکت</label>
                                <textarea name="en_address" class="form-control{{ $errors->has('en_address') ? ' is-invalid' : '' }} summernote text-left">{{ old('en_address') }}</textarea>
                                @if ($errors->has('en_address'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('en_address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            
                            <div class="form-group col-md-12 required">
                                <label>شناسه ملی</label>
                                <input type="text" name="national_id" value="{{ old('national_id') }}" dir="ltr" class="form-control">
                                @if ($errors->has('national_id'))
                                    <span class="invalid-feedback  d-block">
                                        <strong>{{ $errors->first('national_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h4 class="title">کاربری</h4>
                            <span>مشخصات فردی کاربری که قرار است به نمایندگی از شرکت ثبت درخواست کند</span>
                            <hr>
                            <br>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group required">
                                <label class="control-label" for="name">{{ trans('backpack::base.name') }}</label>
    
                                <div>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}">
    
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback  d-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="col-md-6 form-group required">
                                <label class="control-label" for="{{ backpack_authentication_column() }}">{{ config('backpack.base.authentication_column_name') }}</label>
    
                                <div>
                                    <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control{{ $errors->has(backpack_authentication_column()) ? ' is-invalid' : '' }}" name="{{ backpack_authentication_column() }}" id="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}">
    
                                    @if ($errors->has(backpack_authentication_column()))
                                        <span class="invalid-feedback  d-block">
                                            <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="col-md-6 form-group required">
                                <label class="control-label" for="password">{{ trans('backpack::base.password') }}</label>
    
                                <div>
                                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">
    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback  d-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="col-md-6 form-group required">
                                <label class="control-label" for="password_confirmation">{{ trans('backpack::base.confirm_password') }}</label>
    
                                <div>
                                    <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">
    
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback  d-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>



                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
                <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
            @endif
            <div class="text-center"><a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a></div>
        </div>
    </div>
@endsection
