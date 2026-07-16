@if ($crud->hasAccess('truckContractTerminate') and $entry->contract_status == \Modules\Unity\Enums\DriverContractStatus::Active->value)
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/truck-contract-terminate') }}" class="btn btn-sm btn-link"><i class="la la-user-slash"></i><span class="label">فسخ</span></a>
@endif