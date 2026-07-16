
@if ($crud->hasAccess('correctionTraficPermit') and $entry->status == \Modules\TraficPermit\Enums\TraficPermitStatus::Issued->value)
    <a href="javascript:void(0)" data-serial="{{$entry->serial_number}}" onclick="correctionTraficPermit(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/correction-trafic-permit') }}" class="btn btn-xs btn-info" data-button-type="carcass-delivery"><i class="fa fa-form"></i>{!! trans('traficpermit::traficpermit.correction') !!}</a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
    if (typeof correctionTraficPermit != 'function') {
      $("[data-button-type=clone]").unbind('click');

      function correctionTraficPermit(button) {
          // ask for confirmation before deleting an item
          // e.preventDefault();
          var button = $(button);
          var route = button.attr('data-route');
          var serial_number = button.attr('data-serial');

          swal({
		  title: "شماره سریال : "+serial_number,
		  text: "{!! trans('traficpermit::traficpermit.correction_warning') !!}",
		  icon: "warning",
		  buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('traficpermit::traficpermit.correction_submit') !!}"],
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
                            text: "<strong>ثبت اصلاحی</strong><br>تحویل لاشه و ثبت اصلاحی با موفقیت انجام شد."
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
                            text: "<strong>تحویل ناقص</strong><br>مشکلی در ثبت اصلاحی رخ داد . لطفا مجدد تلاش کنید."
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