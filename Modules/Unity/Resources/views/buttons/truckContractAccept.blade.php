@if ($crud->hasAccess('truckContractTerminate')
  and $entry->contract_status == \Modules\Unity\Enums\TruckContractStatus::Pending->value
  and backpack_user()->can('truckcontract manage all'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/truck-contract-accept') }}" class="btn btn-sm btn-link"><i class="la la-check"></i><span class="label">تایید</span></a>
@endif
