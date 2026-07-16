
@if ($crud->hasAccess('carcassDelivery') and $entry->status == \Modules\TraficPermit\Enums\TraficPermitStatus::Issued->value)
    <a href="javascript:void(0)" data-serial="{{$entry->serial_number}}" onclick="carcassDelivery(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/carcass-delivery') }}" class="btn btn-xs btn-success" data-button-type="carcass-delivery"><i class="fa fa-form"></i>{!! trans('traficpermit::traficpermit.carcass_delivery') !!}</a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
    if (typeof carcassDelivery != 'function') {
      $("[data-button-type=clone]").unbind('click');

      function carcassDelivery(button) {
          // ask for confirmation before deleting an item
          // e.preventDefault();
          var button = $(button);
          var route = button.attr('data-route');
          var serial_number = button.attr('data-serial');

          

          swal({
		  title: "شماره سریال : "+serial_number,
		  text: "{!! trans('traficpermit::traficpermit.carcass_delivery_warning') !!}",
		  icon: "warning",
		  buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('traficpermit::traficpermit.carcass_delivery') !!}"],
		  dangerMode: false,
		}).then((value) => {
			if (value) {
				$.ajax({
                    url: route,
                    type: 'POST',
                    success: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "success",
                            text: "<strong>دریافت لاشه</strong><br>دریافت لاشه با موفقیت انجام شد."
                        }).show();

                        // Hide the modal, if any
                        $('.modal').modal('hide');

                        if (typeof crud !== 'undefined') {
                            crud.table.ajax.reload();
                        }
                    },
                    error: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "warning",
                            text: "<strong>ثبت ناقص</strong><br>مشکلی در دریافت لاشه رخ داد . لطفا مجدد تلاش کنید."
                        }).show();
                    }
                });
			}
		});
      }
    }

    // make it so that the function above is run after each DataTable draw event
    // crud.addFunctionToDataTablesDrawEventQueue('cloneEntry');
</script>
@if (!request()->ajax()) @endpush @endif