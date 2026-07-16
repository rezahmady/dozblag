
@if ($crud->hasAccess('cancelOrderTraficPermit') and !$entry->exports()->exists() and is_null($entry->deleted_at))
    <a href="javascript:void(0)" onclick="cancelOrderTraficPermit(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/cancel-order-trafic-permit') }}" class="btn btn-sm btn-link" data-button-type="cancel-order-trafic-permit"><i class="la la-trash"></i><span class="label">{!! trans('traficpermit::traficpermit.cancel_order') !!}</span></a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
    if (typeof cancelOrderTraficPermit != 'function') {
      $("[data-button-type=clone]").unbind('click');

      function cancelOrderTraficPermit(button) {
          // ask for confirmation before deleting an item
          // e.preventDefault();
          var button = $(button);
          var route = button.attr('data-route');
          var serial_number = button.attr('data-serial');

          swal({
		  title: "حذف درخواست",
		  text: "{!! trans('traficpermit::traficpermit.cancel_order_warning') !!}",
		  icon: "warning",
		  buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('traficpermit::traficpermit.cancel_order_submit') !!}"],
		  dangerMode: true,
		}).then((value) => {
			if (value) {
				$.ajax({
                    url: route,
                    type: 'POST',
                    success: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "success",
                            text: "<strong>انصراف از درخواست</strong><br>حذف درخواست با موفقیت انجام شد."
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
                            text: "<strong>خطا در انصراف</strong><br>مشکلی در حذف درخواست رخ داد . لطفا مجدد تلاش کنید."
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