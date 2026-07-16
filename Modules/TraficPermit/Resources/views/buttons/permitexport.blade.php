@if ($crud->hasAccess('traficpermitexport'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/permitexport') }}" class="btn btn-sm btn-link"><i class="la la-print"></i><span class="label">صدور</span></a>
@endif