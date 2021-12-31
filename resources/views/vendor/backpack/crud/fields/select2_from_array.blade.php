<!-- select2 from array -->
@php
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
@endphp
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <select
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        style="width: 100%"
        data-init-function="bpFieldInitSelect2FromArrayElement"
        data-language="{{ str_replace('_', '-', app()->getLocale()) }}"
        data-show-when="{{ json_encode($field['show_when'] ?? []) }}"
        data-hide-when="{{ json_encode($field['hide_when'] ?? []) }}"
        @include('crud::fields.inc.attributes', ['default_class' =>  'form-control select2_from_array'])
        @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
        >

        @if ($field['allows_null'])
            <option value="">-</option>
        @endif

        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if((old(square_brackets_to_dots($field['name'])) && (
                        $key == old(square_brackets_to_dots($field['name'])) ||
                        (is_array(old(square_brackets_to_dots($field['name']))) &&
                        in_array($key, old(square_brackets_to_dots($field['name'])))))) ||
                        (null === old(square_brackets_to_dots($field['name'])) &&
                            ((isset($field['value']) && (
                                        $key == $field['value'] || (
                                                is_array($field['value']) &&
                                                in_array($key, $field['value'])
                                                )
                                        )) ||
                                (!isset($field['value']) && isset($field['default']) &&
                                ($key == $field['default'] || (
                                                is_array($field['default']) &&
                                                in_array($key, $field['default'])
                                            )
                                        )
                                ))
                        ))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
    </select>

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
    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    @if (app()->getLocale() !== 'en')
    <script src="{{ asset('packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js') }}"></script>
    @endif
    <script>
        function bpFieldInitSelect2FromArrayElement(element) {
            if (!element.hasClass("select2-hidden-accessible"))
                {
                    element.select2({
                        theme: "bootstrap"
                    }).on('select2:unselect', function(e) {
                        if ($(this).attr('multiple') && $(this).val().length == 0) {
                            $(this).val(null).trigger('change');
                        }
                    });
                    window.hiddenFields = window.hiddenFields || {};
                    /**
                     *  Toggle function to set the visible state show() or hide() when the values sets in the toggle_when_not
                     */
                    let toggle = function( $field ) {
                        const attr = $field.attr('data-repeatable-input-name');

                        let showWhen = $field.data('show-when'),
                        hideWhen = $field.data('hide-when'),
                        value    = $field.val(),
                        index = $field.attr('data-row-number'),
                        fieldName = $field.attr('name') ?? $field.attr('data-repeatable-input-name'),
                        hiddenFields = (index) ? {} : [];

                        if(index && hiddenFields[index] === undefined) {
                            hiddenFields[index] = {}
                        }

                        if (typeof attr !== 'undefined' && attr !== false) {
                            hiddenFields[index][ fieldName ] = [];
                        } else {
                            hiddenFields[ fieldName ] = hiddenFields[ fieldName ] || [];
                        }



                        if( Object.keys(showWhen).length ){
                            $.each(showWhen, function(idx, obj){
                                let fields = showWhen[idx];
                                $.each(fields, function(idx, name){
                                    let f = $('[name="'+name+'"]').parents('.form-group');
                                    if(!f.length) f = $('[data-repeatable-input-name="'+name+'"]').closest('.form-group');
                                    if( f.length ){
                                        if (f.data('hide_count')) {
                                            f.data('hide_count', f.data('hide_count') + 1);
                                        } else {
                                            f.data('hide_count', 1);
                                        }
                                        if (typeof attr !== 'undefined' && attr !== false) {
                                            hiddenFields[index][ fieldName ].push(f);
                                            f.eq(index - 1).hide();
                                        } else {
                                            hiddenFields[ fieldName ].push(f);
                                            f.hide();
                                        }
                                    }
                                });
                            });
                            if (typeof attr !== 'undefined' && attr !== false) {
                                hiddenFields[index][ fieldName ] = [];
                            } else {
                                hiddenFields[ fieldName ] = [];
                            }
                        }
                        if(  typeof showWhen[value] !== "undefined" && showWhen[value].length ){
                            $.each(showWhen[value], function(idx, name){
                                let f = $('[name="'+name+'"]').parents('.form-group');
                                if(!f.length) f = $('[data-repeatable-input-name="'+name+'"]').closest('.form-group');
                                if( f.length ){
                                    if (f.data('hide_count')) {
                                        f.data('hide_count', f.data('hide_count') + 1);
                                    } else {
                                        f.data('hide_count', 1);
                                    }
                                    if (typeof attr !== 'undefined' && attr !== false) {
                                        hiddenFields[index][ fieldName ].push(f);
                                        f.eq(index - 1).show();
                                    } else {
                                        hiddenFields[ fieldName ].push(f);
                                        f.show();
                                    }
                                }
                            });
                        }
                        if( Object.keys(hideWhen).length ){
                            $.each(hideWhen, function(idx, obj){
                                let fields = hideWhen[idx];
                                $.each(fields, function(idx, name){
                                    let f = $('[name="'+name+'"]').parents('.form-group');
                                    if(!f.length) f = $('[data-repeatable-input-name="'+name+'"]').closest('.form-group');
                                    if( f.length ){
                                        if (f.data('hide_count')) {
                                            f.data('hide_count', f.data('hide_count') + 1);
                                        } else {
                                            f.data('hide_count', 1);
                                        }
                                        if (typeof attr !== 'undefined' && attr !== false) {
                                            hiddenFields[index][ fieldName ].push(f);
                                            f.eq(index - 1).show();
                                        } else {
                                            hiddenFields[ fieldName ].push(f);
                                            f.show();
                                        }
                                    }
                                });
                            });
                            if (typeof attr !== 'undefined' && attr !== false) {
                                hiddenFields[index][ fieldName ] = [];
                            } else {
                                hiddenFields[ fieldName ] = [];
                            }
                        }
                        if(  typeof hideWhen[value] !== "undefined" && hideWhen[value].length ){
                            $.each(hideWhen[value], function(idx, name){
                                let f = $('[name="'+name+'"]').parents('.form-group');
                                if(!f.length) f = $('[data-repeatable-input-name="'+name+'"]').closest('.form-group');
                                if( f.length ){
                                    if (f.data('hide_count')) {
                                        f.data('hide_count', f.data('hide_count') + 1);
                                    } else {
                                        f.data('hide_count', 1);
                                    }
                                    if (typeof attr !== 'undefined' && attr !== false) {
                                        hiddenFields[index][ fieldName ].push(f);
                                        f.eq(index - 1).hide();
                                    } else {
                                        hiddenFields[ fieldName ].push(f);
                                        f.hide();
                                    }
                                }
                            });
                        }
                    };


                    // Target element with class.
                    element.on('change', function(){
                        return toggle( $(this) );
                    });

                    //init, on first load.
                    element.each(function(){
                        return toggle( $(this) );
                    });
                }
        }
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
