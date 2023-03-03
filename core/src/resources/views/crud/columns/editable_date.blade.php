@php
    $column['escaped'] = $column['escaped'] ?? true;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
    $value = data_get($entry, $column['name']);
@endphp

<span class="editable-date" data-name="{{ $column['name'] }}" data-type="date" data-pk="{{ $entry->getKey() }}" data-url="{{ url($crud->route.'/'.$entry->getKey()) }}" data-title="{{ trans('backpack::crud.edit') }} {{ $column['label'] }}">
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        {!! $column['prefix'] !!}
        {{ ($value && (isset($column['format']) ? \Carbon\Carbon::parse($value)->format($column['format']) : \Carbon\Carbon::parse($value)->isoFormat('L'))) }}
        {!! $column['suffix'] !!}
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>

@push('crud_list_scripts')
<script>
$(function () {
  // make editable
  $('.editable-date').editable({
      emptytext: '<i class="la la-calendar"></i>',
      format: 'yyyy-mm-dd',
      viewformat: 'dd/mm/yyyy',
      datepicker: {
          weekStart: 1
      },
      success: function(response) {
          if (response.success == true) {
              new Noty({
                  type: "success",
                  text: "<strong>{{ trans('backpack::crud.update_success') }}</strong><br>"+response.message
              }).show();
          } else {
              new Noty({
                  type: "error",
                  text: "<strong>{{ trans('backpack::crud.update_failed') }}</strong><br>"+response.message
              }).show();
          }
      }
  });
});
</script>
@endpush