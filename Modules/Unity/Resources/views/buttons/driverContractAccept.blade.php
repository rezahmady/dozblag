@if ($crud->hasAccess('driverContractTerminate')
  and $entry->contract_status == \Modules\Unity\Enums\DriverContractStatus::Pending->value
  and backpack_user()->can('drivercontract manage all'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/driver-contract-accept') }}" class="btn btn-sm btn-link"><i class="la la-check"></i><span class="label">تایید</span></a>
@endif
