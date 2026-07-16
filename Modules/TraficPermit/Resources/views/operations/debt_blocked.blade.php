@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.add') => false,
  ];

  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>ثبت درخواست جدید</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8 col-lg-6">
		<div class="card border-0 shadow-sm">
			<div class="card-body text-center py-5 px-4">
				<div class="mb-4">
					<span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger text-white" style="width: 72px; height: 72px;">
						<i class="la la-exclamation-triangle" style="font-size: 2.25rem;"></i>
					</span>
				</div>

				<h3 class="mb-3">ثبت درخواست ممکن نیست</h3>

				<p class="text-muted mb-4 leading-relaxed">
					به‌دلیل بدهی شرکت، امکان ثبت درخواست جدید وجود ندارد.
					لطفاً ابتدا بدهی خود را تسویه کنید و سپس دوباره اقدام نمایید.
				</p>

				<div class="bg-light rounded py-3 px-4 mb-4 d-inline-block">
					<div class="text-muted small mb-1">مبلغ بدهی</div>
					<div class="h4 mb-0 text-danger font-weight-bold" dir="ltr">
						-{{ $debt_formatted }}
						<span class="text-muted small font-weight-normal">تومان</span>
					</div>
				</div>

				<div class="d-flex flex-wrap justify-content-center" style="gap: .75rem;">
					@if ($crud->hasAccess('list'))
						<a href="{{ url($crud->route) }}" class="btn btn-outline-secondary">
							<i class="la la-list"></i> بازگشت به لیست درخواست‌ها
						</a>
					@endif
					<a href="{{ backpack_url('dashboard') }}" class="btn btn-primary">
						<i class="la la-wallet"></i> مشاهده موجودی در داشبورد
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
