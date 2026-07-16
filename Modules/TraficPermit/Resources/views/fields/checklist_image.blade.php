<!-- checklist -->
@php

  $field['attribute'] = $field['attribute'] ?? (new $field['model'])->identifiableAttribute();

  $field['options'] = $field['options'] ?? [];

  // calculate the value of the hidden input
  $field['value'] = old_empty_or_null($field['name'], []) ??  $field['value'] ?? $field['default'] ?? [];

  $field['value'] = (is_string($field['value'])) ? json_decode($field['value']) : $field['value'];

  // define the init-function on the wrapper
  $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';

  $types = \Modules\TraficPermit\Models\TraficPermitType::get();

  if(sizeof($field['options'])) {
    //$field['options'] = sort_countries($field['options']);
  }

  function sort_countries($items) { 
        if(is_array($items)) usort($items, function($a, $b) {
            if($a['lft'] == $b['lft']) {
                return 0;
            }
            return ($a['lft'] < $b['lft'] ? -1 : 1);
        });
        return $items;
  }
@endphp

@include('crud::fields.inc.wrapper_start')
    <label >{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

    {{-- HINT --}}
    @if (isset($field['hint']))
      <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
    <div class="container" style="padding: 0;">
      <div class="row">
          <div class="col-sm-12 text-center" style="padding: 0 10px;">
            <label class="image-checkbox header font-weight-normal">
              <div class="d-flex">
                <div class="image-holder" style="padding: 10px 10px 0 9px" >
                  انتخاب
                </div>
                <div class="title-holder">
                   کشور
                </div>

                <i class="image-checkbox-i la la-check d-none"></i>
              </div>
              <div class="trafic-permit-types">
                @foreach($types as $type)
                <class class="la-column head">{{$type->title}}</class>
                @endforeach
              </div>
            </label>
          </div>

          
          @foreach ($field['options'] as $option)

          <div class="col-sm-12 text-center" style="padding: 0 10px;">
            <label class="image-checkbox font-weight-normal @if($option['disabled']) disabled @endif">
              <div class="d-flex">
                <div class="image-holder" >
                  <i class="image-default-checkbox la la-check"></i>
                  <i class="image-checkbox-i la la-check d-none"></i>
                </div>
                <div class="title-holder">
                  <input type="checkbox" @if($option['disabled']) disabled @endif value="{{ $option['unique_key'] }}" /> {{ $option['full_name'] }}
                </div>

              </div>
              <div class="trafic-permit-types">
                @foreach($types as $type)
                <class class="la-column"><i class="la la-check @if(!in_array($type->id, $option['types_array'])) disabled  @endif"></i></class>
                @endforeach
              </div>
            </label>
          </div>
          @endforeach
      </div>
    </div>

@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}

    @push('crud_fields_styles')
    <style>
        .nopad {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        /*image gallery*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border-top: 2px solid #f5f9fc;
            /* border-right: 0;
            border-left: 0; */
            margin-bottom: 0;
            outline: 0;
            /* background-color: #f5f9fc; */
            background-color: white;
            /* background-image: linear-gradient(132deg,#edf7ff 0%,#d4ecff 100%); */
            /* border-radius: 10px; */
            padding: 0px;
            font-weight: 400 !important;
            font-size: 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .image-checkbox.header {
          border-bottom: 3px solid #f5f9fc;
          background: #f5f9fc;
        }


        .image-checkbox.disabled {
          background-color: #e7e7e7;
          background-image: linear-gradient(132deg,#e7e7e7 0%,#aeaeae 100%);
        }
        
        .title-holder {
          display: flex;
          align-items: center;
        }

        .image-holder {
          border-left: 2px solid #f5f9fc;
          padding: 10px 19px;
        }

        .image-holder .img-responsive {
          width: 50px;
          height: 50px;
          border-radius: 20px;
        }

        .trafic-permit-types {
          display: flex;
        }

        .trafic-permit-types .la {
          color: #6faf29;
          background-color: #f5f9fc;
          padding: 4px;
          border-radius: 8px;
        }

        .trafic-permit-types .la.disabled {
          color: #f5f9fc;
        }

        .trafic-permit-types .la-column {
          padding: 0 22px;
          border-right: 2px solid #f5f9fc;
          display: flex;
          align-items: center;
        }

        .trafic-permit-types .la-column.head {
          width: 70px;
          text-align: center;
          padding: 0;
          align-items: center;
          justify-content: center;
        }

        .title-holder {
          padding: 10px;
        }

        .image-checkbox input[type="checkbox"] {
            display: none;
        }

        .image-checkbox-checked {
            background-color: #56cc96;
            background-image: linear-gradient(132deg,#edf7ff 0%,#56cc96 100%);
        }

        .image-checkbox-i.la {
          position: absolute;
          z-index: 1;
          color: #6faf29;
          background-color: white;
          padding: 4px;
          top: 12px;
          right: 29px;
          border-radius: 8px;
        }

        .image-checkbox-i.la.disabled {
          color: #a2a2a2;
        }

        .image-default-checkbox {
          color: #d8d8d8;
          background-color: #d8d8d8;
          padding: 4px;
          top: 7px;
          right: 22px;
          border-radius: 8px;
          z-index: 0;
        }

        .image-checkbox-checked .image-checkbox-i {
          display: block !important;
        }

        .col-md-8.bold-labels .card-body {
          padding-bottom: 0;
        }
        
        .col-md-8.bold-labels .card {
          overflow: hidden;
        }

        @media (max-width: 540px) {
          .mobile-overflow-x {
            overflow-x : scroll;
            width: 100%;
          }
        }
    </style>
    @endpush
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        @loadOnce('bpFieldInitChecklist')
        <script>
            function bpFieldInitChecklist(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                var checkboxes = element.find('input[type=checkbox]');
                var container = element.find('.row');

                console.log(selected_options);

                // set the default checked/unchecked states on checklist options
                checkboxes.each(function(key, option) {
                  var id = $(this).val();
                  
                  if (selected_options.map(String).includes(id)) {
                    $(this).closest('.image-checkbox').addClass('image-checkbox-checked');
                    // var $checkbox = $(this).find('input[type="checkbox"]');
                    // $checkbox.prop("checked",'checked')
                    $(this).prop('checked', 'checked');
                  } else {
                    $(this).closest('.image-checkbox').removeClass('image-checkbox-checked');
                    // var $checkbox = $(this).find('input[type="checkbox"]');
                    // $checkbox.prop("checked",false)
                    $(this).prop('checked', false);
                  }
                });

                // when a checkbox is clicked
                // set the correct value on the hidden input
                checkboxes.click(function() {
                  var newValue = [];

                  $(this).closest('.image-checkbox').toggleClass('image-checkbox-checked');

                  checkboxes.each(function() {
                    if ($(this).is(':checked')) {
                      var id = $(this).val();
                      newValue.push(id);
                    }
                  });

                  hidden_input.val(JSON.stringify(newValue)).trigger('change');

                });

                hidden_input.on('CrudField:disable', function(e) {
                    checkboxes.attr('disabled', 'disabled');
                });

                hidden_input.on('CrudField:enable', function(e) {
                    checkboxes.removeAttr('disabled');
                });

            }

            // $(".image-checkbox").each(function () {
            // if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
            //     $(this).addClass('image-checkbox-checked');
            // }
            // else {
            //     $(this).removeClass('image-checkbox-checked');
            // }
            // });

            // // sync the state to the input
            // $(".image-checkbox").on("click", function (e) {
            // $(this).toggleClass('image-checkbox-checked');
            // var $checkbox = $(this).find('input[type="checkbox"]');
            // $checkbox.prop("checked",!$checkbox.prop("checked"))

            // e.preventDefault();
            // });
        </script>
        @endLoadOnce
    @endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}

