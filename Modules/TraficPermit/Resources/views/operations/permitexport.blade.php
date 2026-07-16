@extends(backpack_view('layouts.top_left'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'صدور' => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $types = \Modules\TraficPermit\Models\TraficPermitType::get();

  $orders = json_decode($crud->getCurrentEntry()->orders);

  $exports = $crud->getCurrentEntry()->traficPermits()->wherePivot('status', 1)->get();
  $traficpermits = [];
  foreach($orders as $key=>$order) {
	$order_string = $order;
	$order = explode(':', $order);
	$order_types = explode('-', $order[1]);
	$traficpermits[$key] = [
		'country_name' => \Modules\TraficPermit\Models\Country::find($order[0])->fa_name,
		'country_id' => $order[0],
		'types' => $order_types,
		'unique_key' => $orders[$key],
		'selected' => false
	];
	foreach($exports as $export) {
		if($traficpermits[$key]['unique_key'] == $export->repository->unique_key) {
			$traficpermits[$key]['selected'] = true;
			$traficpermits[$key]['serial_number'] = $export->serial_number;
			$traficpermits[$key]['id'] = $export->id;
		}
	}
  }

@endphp

@section('header')
  <section class="container-fluid">
    <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getCurrentEntry()->unity->fa_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
    </h2>
  </section>
@endsection

@section('content')

<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="">
	  	@if ($crud->model->translationEnabled())
			<div class="row">
				<div class="col-md-12 mb-2">
					<!-- Change translation button group -->
					<div class="btn-group float-right">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						@foreach ($crud->model->getAvailableLocales() as $key => $locale)
							<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
						@endforeach
					</ul>
					</div>
				</div>
			</div>
	    @endif
	    <div class="card no-padding no-border">
			<table class="table table-striped mb-0">
		        <tbody>
		        @foreach ($crud->columns() as $column)
		            <tr>
		                <td>
		                    <strong>{!! $column['label'] !!}:</strong>
		                </td>
                        <td>
                        	@php
                        		// create a list of paths to column blade views
                        		// including the configured view_namespaces
                        		$columnPaths = array_map(function($item) use ($column) {
                        			return $item.'.'.$column['type'];
                        		}, config('backpack.crud.view_namespaces.columns'));

                        		// but always fall back to the stock 'text' column
                        		// if a view doesn't exist
                        		if (!in_array('crud::columns.text', $columnPaths)) {
                        			$columnPaths[] = 'crud::columns.text';
                        		}
                        	@endphp
													@includeFirst($columnPaths)
                        </td>
		            </tr>
		        @endforeach
				@if ($crud->buttons()->where('stack', 'line')->count())
					<tr>
						<td><strong>{{ trans('backpack::crud.actions') }}</strong></td>
						<td>
							@include('crud::inc.button_stack', ['stack' => 'line'])
						</td>
					</tr>
				@endif
		        </tbody>
			</table>
	    </div><!-- /.box-body -->
	  </div><!-- /.box -->

	</div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">		  
		  @foreach($traficpermits as $key => $traficpermit)
			<form 
			x-data="traficpermit()" 
			x-init="index = {{$key}}; @if($traficpermit['selected']) layer = 5  @endif"
			id="form{{$key}}" x-ref="form" name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('store-form')}}">
				@csrf
				<div  
				class="card trafic-permit"
				>
					<div class="card-header">
						<div>@if(array_key_exists('id',$traficpermit)) <a href="{{backpack_url('/trafic-permit?serial_number='.$traficpermit['serial_number'])}}" > @endif {{$traficpermit['country_name']}} @if(array_key_exists('serial_number',$traficpermit)) : {{ $traficpermit['serial_number'] }} @endif @if(array_key_exists('id',$traficpermit)) </a> @endif</div>
						<div class="trafic-permit-types">
							@foreach($types as $type)
							<class class="la-column"><i class="la la-check @if(!in_array($type->id, $traficpermit['types'])) disabled  @endif"></i><span class="ml-1">{{$type->title}}</span></class>
							@endforeach
						</div>
					</div>
					<div class="card-body p-0"
					@set-layer-{{$key}}.window="set_layer($event.detail, $dispatch)"
					>
						<div class="select-trafic-permit w-100" >
							<input type="hidden" name="index" value='{{$key}}'>
							<input type="hidden" name="orders" value='{{$crud->getCurrentEntry()->orders}}'>
							<input type="hidden" name="order" value='{{$traficpermit['unique_key']}}'>
							<input type="hidden" name="permit_order_id" value='{{$crud->getCurrentEntry()->id}}'>
							<input type="hidden" name="country_id" value='{{$traficpermit['country_id']}}'>
							<input type="hidden" name="types" value='@json($traficpermit['types'])'>
							@if(view()->exists('vendor.backpack.crud.form_content'))
								@include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
							@else
								@include('crud::form_content', ['fields' => $$crud->fields(), 'action' => 'edit'])
							@endif
							<div x-show="layer == 2" class="overlayer info">
								<span>پرینت با موفقیت انجام شد؟</span>
							</div>
							<div x-show="layer == 3" class="overlayer warning">
								<span>از حذف این مورد اطمینان دارید؟</span>
							</div>
						</div>
 
						<div class="trafic-permit-actions">
							<class x-transition.enter.scale class="la-column print" x-on:click="before_print()" x-show="layer === 1"><i class="la la-print"></i><span class="label">چاپ</span></class>
							<class x-transition.enter.scale class="la-column fail" x-on:click="before_remove_order()" x-show="layer === 1"><i class="la la-trash"></i><span class="label">حذف</span></class>
							<class x-transition.enter.scale class="la-column edit" x-on:click="undo()" x-show="layer != 1 && layer != 4 && layer != 5"><i class="la la-undo-alt"></i><span class="label">بازگشت</span></class>
							<class x-transition.enter.scale class="la-column check" x-on:click="remove_order()" x-show="layer == 3"><i class="la la-check"></i><span class="label">تایید</span></class>
							<class x-transition.enter.scale class="la-column check" x-on:click="print()" x-show="layer == 2"><i class="la la-check"></i><span class="label">تایید</span></class>
						</div> 

						<div x-show="layer === 4" class="overlayer warning">
							<span>حذف شد</span>
						</div>

						<div x-show="layer === 5" class="overlayer success">
							<span>صادر شد</span>
						</div>
					</div>
				</div>
			</form>
		  @endforeach
    </div>
</div>

<style>
	.table.table-striped {
		border-radius: 10px;
    	overflow: hidden;
	}
	.card {
		margin-bottom: 10px;
	}
	.trafic-permit .card-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		border-bottom: 3px solid #f5f9fc;
	}

	.overlayer {
		position: absolute;
		width: 100%;
		top: 0;
		bottom: 0;
		padding: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	
	.overlayer.info {
		color: white;
		background-color: #088ff5;
	}

	.overlayer.warning {
		color: white;
		background-color: #c41818;
	}

	.overlayer.success {
		color: white;
		background-color: #28ad30;
	}

	.trafic-permit .card-body {
		display: flex;
		justify-content: space-between;
		position: relative;
	}

	.trafic-permit .form-group {
		margin-bottom: 0;
		display: flex;
		align-items: center;
	}

	.trafic-permit-types {
		display: flex;
	}

	.trafic-permit-types .la {
		color: #6faf29;
		background-color: #f5f9fc;
		padding: 4px;
		border-radius: 8px;
	}

	.trafic-permit-types .la.disabled {
		color: #f5f9fc;
	}

	.trafic-permit-types .la-column {
		padding: 0 22px;
		display: flex;
		align-items: center;
	}

	.input-group-prepend {
		height: 38px;
	}

	.trafic-permit-types .la-column.head {
		width: 70px;
		text-align: center;
		padding: 0;
		align-items: center;
		justify-content: center;
	}

	.select-trafic-permit {
		display: flex;
		align-items: center;
		padding: 10px;
		justify-content: center;
		position: relative;
	}

	.select-trafic-permit .card {
		padding: 0;
		margin: 0;
		box-shadow: none;
		width: 80%;
	}

	.select-trafic-permit .card-body {
		padding: 0;
		margin: 0;
	}

	.trafic-permit-actions i {
		font-size: 30px;
	}

	.trafic-permit-actions i.disabled {
		color: #f5f9fc;
	}

	.trafic-permit-actions {
		display: flex;
	}

	.trafic-permit-actions .la-column {
		border-right: 2px solid #f5f9fc;
		display: flex;
		align-items: center;
    	padding: 30px;
		cursor: pointer;
		flex-direction: column;
		color: #737373;
		position: relative;
	}

	.trafic-permit-actions .la-column .label {
		display: none;
		position: absolute;
		bottom: 10px;
		font-size: 12px;
	}

	.trafic-permit-actions .la-column:hover .label {
		display: block;
	}

	.trafic-permit-actions .la-column.print:hover {
		background-color: #f5f9fc;
		color: var(--main);
	}
	
	.trafic-permit-actions .la-column.fail:hover {
		background-color: #fcf5f5;
		color: #f50808 !important;
	}

	.trafic-permit-actions .la-column.check:hover {
		background-color: #f5fcf7;
		color: #0dc20c;
	}

	.trafic-permit-actions .la-column.edit:hover {
		background-color: #fcfbf5;
	    color: #ffc107;
	}

	.select2.select2-container {
		border: 0 !important;
		background: #f5f9fc;
    	border-radius: 10px;
	}

	.select2-container--bootstrap[dir=rtl] .select2-selection--single {
		border: 0 !important;
		background: #f5f9fc;
    	border-radius: 10px;
	}

	form .select2.select2-container {
		border: 0 !important;
	}

	.select2-selection__placeholder {
		color: var(--main) !important;
	}

	.printpage {
		display: none;
	}

	@media print {
		.printpage {
			display: block;
		}
	}
</style>

@endsection

@section('before_scripts')

<script>
	
document.addEventListener('alpine:init', () => {
    Alpine.data('traficpermit', () => ({
		index: 0,
        layer:1,
		submitting: false,
        before_print() {
			if (this.submitting) return;
			this.submitting = true;
			var self = this;
			var bodyFormData = $(this.$root).serialize();
            axios.post("{{url('/api/traficpermit/print')}}", bodyFormData)
            .then(function (response) {
				// handle success
				res = response.data 
				if(res.status) {
					let event = new CustomEvent('set-layer-'+res.index, {
						detail: { value: 2 }
					});
					window.dispatchEvent(event);

					const link = res.link;
					$("<iframe class='printpage'>") // create a new iframe element
					.attr("src", link) // point the iframe to the page link you want to print
					.appendTo("body");

					new Noty({
						type: "info",
						text: res.message,
					}).show();
				} else {
					new Noty({
						type: "danger",
						text: res.message,
					}).show();
				}
            })
            .catch(function (error) {
                // handle error
				//console.log(error)
				new Noty({
					type: "danger",
					text: "{{trans('traficpermit::traficpermit.export_form_error_500')}}",
				}).show();
            })
			.finally(function () {
				self.submitting = false;
			});
        },
        print() {
			if (this.submitting) return;
			this.submitting = true;
			var self = this;
			var bodyFormData = $(this.$root).serialize();
            axios.post("{{url('/api/traficpermit/report')}}", bodyFormData)
            .then(function (response) {
				// handle success
				res = response.data 
				if(res.status) {
					let event = new CustomEvent('set-layer-'+res.index, {
						detail: { value: 5 }
					});
					window.dispatchEvent(event);

					new Noty({
						type: "success",
						text: res.message,
					}).show();
				} else {
					new Noty({
						type: "danger",
						text: res.message,
					}).show();
				}
            })
            .catch(function (error) {
                // handle error
				new Noty({
					type: "danger",
					text: "{{trans('traficpermit::traficpermit.export_form_error_500')}}",
				}).show();
            })
			.finally(function () {
				self.submitting = false;
			});
        },
        undo() {
            this.layer = 1;
        },
        before_remove_order() {
            this.layer = 3;
        },
        remove_order() {
			var bodyFormData = $(this.$root).serialize();
            axios.post("{{url('/api/traficpermit/remove')}}", bodyFormData)
            .then(function (response) {
				// handle success
				res = response.data 
				if(res.status) {
					let event = new CustomEvent('set-layer-'+res.index, {
						detail: { value: 4 }
					});
					window.dispatchEvent(event);

					new Noty({
						type: "success",
						text: res.message,
					}).show();
				} else {
					new Noty({
						type: "danger",
						text: res.message,
					}).show();
				}
            })
            .catch(function (error) {
                // handle error
				new Noty({
					type: "danger",
					text: "{{trans('traficpermit::traficpermit.export_form_error_500')}}",
				}).show();
            });
        },
		set_layer(detail, dispatch) {
			const { value } = detail
			this.layer = value
		}
    }))
})


</script>

@endsection

@push('after_scripts')

@endpush