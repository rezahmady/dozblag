@extends(backpack_user() && (Str::startsWith(\Request::path(), config('backpack.base.route_prefix'))) ? 'backpack::layouts.top_left' : 'backpack::layouts.plain')
{{-- show error using sidebar layout if looged in AND on an admin page; otherwise use a blank page --}}

@php
  $title = 'صفحه اصلی ';
@endphp

@section('after_styles')
  <style>
    .error_number {
      font-size: 156px;
      font-weight: 600;
      line-height: 100px;
    }
    .error_number small {
      font-size: 56px;
      font-weight: 700;
    }

    .error_number hr {
      margin-top: 60px;
      margin-bottom: 0;
      width: 50px;
    }

    .error_title {
      margin-top: 40px;
      font-size: 36px;
      font-weight: 400;
    }

    .error_description {
      font-size: 24px;
      font-weight: 400;
    }

    .jumbotron {
        padding: 2rem 1rem;
    }
  </style>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 text-center">
    <div class="error_number">
      {{-- <small>پوسته پیشفرض</small><br> --}}
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><i class="fa fa-align-justify"></i> <small>پوسته پیشفرض</small>
            {{-- <div class="card-header-actions"><a class="card-header-action" href="http://coreui.io/docs/components/bootstrap-jumbotron/" target="_blank"><small class="text-muted">docs</small></a></div> --}}
          </div>
          <div class="card-body">
            <div class="jumbotron">
              {{-- <h1 class="display-3">Hello, world!</h1> --}}
              <p class="lead">این پوسته به صورت پیش‌فرض نصب شده . می توانید از پنل مدیریت پوسته دلخواه خود را نصب کنید.</p>
              <hr class="my-4">
              {{-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> --}}
              <p class="lead"><a class="btn btn-primary btn-lg" href="{{url('/admin')}}" role="button">رفتن به مدیریت</a></p>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </div>
    <div class="error_title text-muted">
      @yield('title')
    </div>
    <div class="error_description text-muted">
      <small>
        @yield('description')
     </small>
    </div>
  </div>
</div>
@endsection