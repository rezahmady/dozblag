<!-- radio -->
@php
    $optionValue = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';

    // check if attribute is casted, if it is, we get back un-casted values
    if(Arr::get($crud->model->getCasts(), $field['name']) === 'boolean') {
        $optionValue = $optionValue === true ? 1 : 0;
    }

    // if the class isn't overwritten, use 'radio'
    if (!isset($field['attributes']['class'])) {
        $field['attributes']['class'] = 'radio';
    }

    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitRadioImageElement';
@endphp

@include('crud::fields.inc.wrapper_start')

    <div>
        <label>{!! $field['label'] !!}</label>
        @include('crud::fields.inc.translatable_icon')
    </div>

    <input type="hidden" value="{{ $optionValue }}" name="{{$field['name']}}" />

    @if( isset($field['options']) && $field['options'] = (array)$field['options'] )

        @foreach ($field['options'] as $value => $details )

            <label class="form-radio-image {{ isset($field['inline']) && $field['inline'] ? 'form-check-inline' : '' }}">
                <input  type="radio"
                        value="{{$value}}" 
                        @include('crud::fields.inc.attributes')
                        >
                <img src="{{ $details['image'] }}">
                <div class="label">{!! $details['label'] !!}</div>
            </label>

        @endforeach

    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
    <style>
        label.form-radio-image {
            display: inline-block ;
            border:2px solid transparent;
            cursor:pointer;
            width: 150px;
            padding: 10px;
            background: #f1f4f8;
            border-radius: 5px;
            margin: 5px;
        }
        label.form-radio-image.active {
            background: #dfe2e6;
            border: 2px solid #d1d1d2;
        }
        label.form-radio-image > input { /* HIDE RADIO */
        visibility: hidden; /* Makes input not-clickable */
        position: absolute; /* Remove input from document flow */
        }

        label.form-radio-image > .label {
            text-align: center;
            padding: 5px;
            color: #0263a4;
        }
    </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script>
        function bpFieldInitRadioImageElement(element) {
            var hiddenInput = element.find('input[type=hidden]');
            var value = hiddenInput.val();
            var id = 'radio_'+Math.floor(Math.random() * 1000000);

            // set unique IDs so that labels are correlated with inputs
            element.find('.form-check input[type=radio]').each(function(index, item) {
                $(this).attr('id', id+index);
                $(this).siblings('label').attr('for', id+index);
            });

            // when one radio input is selected
            element.find('input[type=radio]').change(function(event) {
                // the value gets updated in the hidden input
                hiddenInput.val($(this).val());
                element.find('label').each(function (item){
                    $(this).removeClass('active');
                })
                $(this).parent('label').addClass('active');
                // all other radios get unchecked
                element.find('input[type=radio]').not(this).prop('checked', false);
            });

            // select the right radios
            element.find('input[type=radio][value="'+value+'"]').prop('checked', true);
            element.find('input[type=radio][value="'+value+'"]').parent('label').addClass('active');
        }
    </script>
    @endpush

@endif
