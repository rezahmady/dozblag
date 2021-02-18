@if ($crud->hasAccess('update'))
    @if ($entry->active)
    <a href="{{ url($crud->route.'/'.$entry->folder.'/activate') }} " class="btn btn-link btn-xs">
        <span class="text-danger">
            حذف
        </span>
    </a>
    @else
    <a href="{{ url($crud->route.'/'.$entry->folder.'/activate') }} " class="btn btn-xs btn-success"><i class="fa fa-ban"></i> نصب</a>
    @endif
@endif