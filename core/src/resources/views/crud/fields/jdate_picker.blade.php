<!-- bootstrap datepicker input -->

<?php
    // if the column has been cast to Carbon or Date (using attribute casting)
    // get the value as a date string
    if (isset($field['value']) && ($field['value'] instanceof \Carbon\CarbonInterface)) {
        $field['value'] = $field['value']->format('Y-m-d');
    }

    $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';
    $field['attributes']['style'] = $field['attributes']['style'] ?? 'background-color: white!important;';
    $field['attributes']['readonly'] = $field['attributes']['readonly'] ?? 'readonly';

    $field_language = isset($field['date_picker_options']['language']) ? $field['date_picker_options']['language'] : \App::getLocale();
?>

@include('crud::fields.inc.wrapper_start')
    <input type="hidden" class="form-control" name="{{ $field['name'] }}" value="{{ $field['value'] }}">
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <div class="input-group date">
        <input
            data-bs-datepicker="{{ isset($field['date_picker_options']) ? json_encode($field['date_picker_options']) : '{}'}}"
            data-init-function="bpFieldInitDatePickerElement"
            value="{{ $field['value'] }}"
            type="text"
            @include('crud::fields.inc.attributes')
            >
            <span style="
            position: absolute;
            left: 43px;
            color: red;
            top: 8px;
            cursor: pointer;
        " class="jdate-calendar-clear">
                <i class="nav-icon la la-close"></i>
            </span>
        <div class="input-group-append">
            <span class="input-group-text">
                <span class="la la-calendar"></span>
            </span>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/packages/persian-datepicker/css/persian-datepicker.min.css') }}" >
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="{{ asset('assets/admin/packages/persian-datepicker/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/admin/packages/persian-datepicker/js/persian-datepicker.min.js') }}"></script>
    <script>
        if (jQuery.ui) {
            var persianDatepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = persianDatepicker;
        } else {
            $.fn.bootstrapDP = $.fn.persianDatepicker;
        }

        function bpFieldInitDatePickerElement(element) {
            var $fake = element
            $field = $fake.closest('.input-group').parent().find('input[type="hidden"]')
            var $existingVal = $field.val();
            
            if( $existingVal.length ) {
                $customConfig = $.extend({
                    format: 'L',
                    autoClose: true,
                    initialValueType: 'gregorian',
                    onSelect: function(unix){
                        setValue(unix)
                    }
                }, $fake.data('bs-datepicker'));
                $fake.closest('.input-group').find('.jdate-calendar-clear').show();
            } else {
                $customConfig = $.extend({
                    format: 'L',
                    autoClose: true,
                    initialValueType: 'gregorian',
                    initialValue: false,
                    onSelect: function(unix){
                        setValue(unix)
                    },
                }, $fake.data('bs-datepicker'));
                $fake.closest('.input-group').find('.jdate-calendar-clear').hide();
            }

            $fake.closest('.input-group').find('.jdate-calendar-clear').click(function (e) {
                $fake.closest('.input-group').parent().find('input[type="hidden"]').val('')
                element.val('')
                $fake.closest('.input-group').find('.jdate-calendar-clear').hide();
            })

            
            $picker = element.bootstrapDP($customConfig);

            if( !$existingVal.length ){
                var d = new Date();
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                var sqlDate = curr_year + "-" + curr_month + "-" + curr_date
                $field.val(sqlDate);
            }

            function setValue(e){
                var d = new Date(e);
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                var sqlDate = curr_year + "-" + curr_month + "-" + curr_date
                $field.val(sqlDate);
                $fake.closest('.input-group').find('.jdate-calendar-clear').show();
            }
        }
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
