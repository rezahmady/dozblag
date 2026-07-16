@if ($crud->hasAccess('restore') and $entry->deleted_at)
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/restore') }}" class="btn" data-style="zoom-in"><span class="ladda-label"><i class="la la-trash-restore la-lg" style="color: #34bcf9;font-size:30px"></i></span></a>
@endif