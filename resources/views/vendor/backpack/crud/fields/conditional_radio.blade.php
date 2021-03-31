{{-- CONDITIONAL FIELD TYPE --}}

@include('crud::fields.inc.wrapper_start')

    <div>
        <label>{!! $field['label'] !!}</label>
        @include('crud::fields.inc.translatable_icon')
    </div>

    <input
        type="hidden"
        data-conditional-field="fields"
        name="{{ $field['name'] }}"
        data-init-function="bpFieldInitConditionalElement"
        value="{{ $field['value'] }}"
        @include('crud::fields.inc.attributes')
    />



    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif



    <div class="container-conditional-elements">
        <div data-conditional-holder="{{ $field['name'] }}"></div>
        
        @push('before_scripts')
        @if (isset($field['fields']) && is_array($field['fields']) && count($field['fields']))
        @foreach($field['fields'] as $key => $groupField)
        <div class="col-md-12 well row m-1 p-2" data-conditional-identifier="{{ $field['name'] }}" data-conditional-value="{{ $key }}">
                @foreach($groupField as $key => $subfield)
                @php
                    $subfield = $crud->makeSureFieldHasNecessaryAttributes($subfield);
                    $fieldViewNamespace = $subfield['view_namespace'] ?? 'crud::fields';
                    $fieldViewPath = $fieldViewNamespace.'.'.$subfield['type'];
                    $subfield['showAsterisk'] = false;
                @endphp

                @include($fieldViewPath, ['field' => $subfield])
                @endforeach
            </div>
            @endforeach

        @endif
        @endpush

    </div>

@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
  @php
      $crud->markFieldTypeAsLoaded($field);
  @endphp
  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

  @push('crud_fields_styles')
      <!-- no styles -->
      <style type="text/css">
        .conditional-element {
          border: 1px solid rgba(0,40,100,.12);
          border-radius: 5px;
          background-color: #f0f3f94f;
        }
      </style>
  @endpush

  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

  @push('crud_fields_scripts')
      <script>
        MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

        var trackChange = function(element) {
            var observer = new MutationObserver(function(mutations, observer) {
                if(mutations[0].attributeName == "value") {
                    $(element).trigger("change");
                }
            });
            observer.observe(element, {
                attributes: true
            });
        }

        // Just pass an element to the function to start tracking
        
       
        /**
         * Takes all inputs and makes them an object.
         */
        function conditionalInputToObj(container_name) {
            var arr = [];
            var obj = {};

            var container = $('[data-conditional-holder='+container_name+']');

            container.find('.well').each(function () {
                $(this).find('input, select, textarea').each(function () {
                    if ($(this).data('conditional-input-name')) {
                        obj[$(this).data('conditional-input-name')] = $(this).val();
                    }
                });
                arr.push(obj);
                obj = {};
            });

            return arr;
        }

        /**
         * The method that initializes the javascript on this field type.
         */
        function bpFieldInitConditionalElement(element) {
            // handel radio input
            var hiddenInput = $("input[name={{ $field['radio_field'] }}]");
            trackChange( hiddenInput[0]);

            var inputValue = hiddenInput.val();
  
            var field_name = "{{ $field["name"] }}";

            // element will be a jQuery wrapped DOM node
            var container = $('[data-conditional-identifier='+field_name+']');

            // make sure the inputs no longer have a "name" attribute,
            // so that the form will not send the inputs as request variables;
            // use a "data-conditional-input-name" attribute to store the same information;
            container.find('input, select, textarea')
                    .each(function(){
                        if ($(this).data('name')) {
                            var name_attr = $(this).data('name');
                            $(this).removeAttr("data-name");
                        } else if ($(this).attr('name')) {
                            var name_attr = $(this).attr('name');
                            $(this).removeAttr("name");
                        }
                        $(this).attr('data-conditional-input-name', name_attr)
                    });

            // make a copy of the group of inputs in their default state
            // this way we have a clean element we can clone when the user
            // wants to add a new group of inputs
            var field_group_clone = container.clone();
            container.remove();

            var FieldsValue = element.val()
            // when one radio input is selected
            hiddenInput.change(function(event) {
                if (FieldsValue.length > 2) {
                    var conditional_fields_values = JSON.parse(FieldsValue);

                    for (var i = 0; i < conditional_fields_values.length; ++i) {
                        showMachGroupFields(container, field_group_clone, conditional_fields_values[i], $(this).val());
                    }
                } else {
                    showMachGroupFields(container, field_group_clone, null,$(this).val());
                }
                // all other radios get unchecked
                element.find('input[type=radio]').not(this).prop('checked', false);
            });

            // select the right radios
            element.find('input[type=radio][value="'+inputValue+'"]').prop('checked', true);

            if (FieldsValue.length > 2) {
                var conditional_fields_values = JSON.parse(FieldsValue);

                for (var i = 0; i < conditional_fields_values.length; ++i) {
                    showMachGroupFields(container, field_group_clone, conditional_fields_values[i], inputValue);
                }
            } else {
                showMachGroupFields(container, field_group_clone, null,inputValue);
            }

            if (element.closest('.modal-content').length) {
                element.closest('.modal-content').find('.save-block').click(function(){
                    element.val(JSON.stringify(conditionalInputToObj(field_name)));
                })
            } else if (element.closest('form').length) {
                element.closest('form').submit(function(){
                    element.val(JSON.stringify(conditionalInputToObj(field_name)));
                    return true;
                })
            }
        }

        /**
         * Adds a new field group to the conditional input.
         */
        function showMachGroupFields(container, field_group, values, selected) {

            var field_name = container.data('conditional-identifier');
            var new_field_group = field_group.clone();
            var options = @JSON($field['options'])

            var index = options.indexOf(selected);
            console.log(selected)

            //this is the container for this conditional group that holds it inside the main form.
            var container_holder = $('[data-conditional-holder='+field_name+']');

            if (values != null) {
                
                // set the value on field inputs, based on the JSON in the hidden input
                new_field_group.find('input, select, textarea').each(function () {
                    if ($(this).data('conditional-input-name')) {
                        $(this).val(values[$(this).data('conditional-input-name')]);

                        // if it's a Select input with no options, also attach the values as a data attribute;
                        // this is done because the above val() call will do nothing if the options aren't there
                        // so the fields themselves have to treat this use case, and look at data-selected-options
                        // and create the options based on those values
                        if ($(this).is('select') && $(this).children('option').length == 0) {
                          $(this).attr('data-selected-options', JSON.stringify(values[$(this).data('conditional-input-name')]));
                        }
                    }
                });
            }
            //we push the fields to the correct container in page.
            container_holder.html(new_field_group[index]);
            initializeFieldsWithJavascript(new_field_group[index]);

        }
    </script>
  @endpush
@endif
