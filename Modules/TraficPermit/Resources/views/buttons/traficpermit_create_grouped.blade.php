<div class="btn-group d-relative" role="group" >
	<button class="btn btn-primary">
		<span class="la la-plus" role="presentation" aria-hidden="true"></span> &nbsp;
		<span data-value="">{{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span>
	</button>
	<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">&#x25BC;</span></button>
	<div class="dropdown-menu long-select" style="left: auto !important;" aria-labelledby="btnGroupDrop1">
		@php
			$countries = \Modules\TraficPermit\Models\Country::where('status', 1)->pluck('fa_name', 'id')->toArray();
		@endphp
		@foreach($countries as $id => $label)
		<a class="dropdown-item" href="{{url($crud->route.'/create?country='.$id)}}"> <small>برای کشور </small> <b>{{ $label }}</b></a>
		@endforeach
	</div>
</div>

<style>
	.dropdown-menu.show.long-select {
		column-count: 3;
		padding: 0px;
		gap: 0px;
		top: 0px;
		/* right: 0; */
		width: max-content;
		transform: translate3d(-1px, 38px, 0px);
		background: #e7eaee;
	} 

	.dropdown-menu.show.long-select .dropdown-item {
		padding: 10px 20px;
		border: 3px solid #e7eaee;
		border-radius: 10px;
		background: white;
	}

	.dropdown-menu.show.long-select .dropdown-item:active {
		color: #fff;
		background-color: #ffc107;
	}

	.dropdown-menu.show.long-select .dropdown-item:hover {
		background-color: #f9fbfd;
		color: #161c2d;
		text-decoration: none;
	}
</style>