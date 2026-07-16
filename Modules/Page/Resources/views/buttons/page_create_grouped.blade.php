<div class="btn-group" role="group" >
	<button class="btn btn-primary">
		<span class="la la-plus" role="presentation" aria-hidden="true"></span> &nbsp;
		<span data-value="">{{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span>
	</button>
	<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">&#x25BC;</span></button>
	<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
		@php $index = 0; @endphp
		@foreach(get_page_templates_array() as $template => $label)
		@php $index++; @endphp
		@if ($index ==4)
		<hr class="mb-0">
		<small class="text-center d-block p-2">افزونه‌ها</small>
		<hr class="mt-0">
		@endif
		<a class="dropdown-item" href="{{url($crud->route.'/create?template='.$template)}}">{{ trans('backpack::crud.add') }} {{ $label }}</a>
		@endforeach
	</div>
</div>