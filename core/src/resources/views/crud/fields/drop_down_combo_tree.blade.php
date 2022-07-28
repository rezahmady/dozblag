<!-- checklist -->
@php

  $model = new $field['model'];
  $key_attribute = $model->getKeyName();
  $identifiable_attribute = $field['attribute'];

  // combo
  $field['combo']['isMultiple'] = $field['combo']['isMultiple'] ?? false;
  $field['combo']['cascadeSelect'] = $field['combo']['cascadeSelect'] ?? true;
  $field['combo']['collapse'] = $field['combo']['collapse'] ?? false;
  $field['combo']['selectableLastNode'] = $field['combo']['selectableLastNode'] ?? false;

  // source
  $sources = $field['model']::where('parent_id', null);

  if(isset($field['scope'])) {
    $sources = $sources->{$field['scope']}();
  }

  if(isset($field['where'])) {
    $sources = $sources->where($field['where'][0],$field['where'][1],$field['where'][2]);
  }

  $sources = $sources->with('childrenRecursive')->select('id','name')->get()->toArray();

  // calculate the value of the hidden input
  $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
  
  if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
    $field['value'] = $field['value']->pluck($key_attribute)->toArray();
  }if ($field['value'] instanceof Illuminate\Support\Collection) {
    $field['value'] = $field['value']->pluck($key_attribute)->toArray();
  } elseif (is_string($field['value'])){
    $field['value'] = json_decode($field['value']);
  }
  $source_array = makeList($sources);
  
  function makeList($array) {
    
		//Base case: an empty array produces no list
    if (empty($array)) return ;
   
		//Recursive Step: make a list with child lists
		$output = [];
		foreach ($array as $key => $subArray) {
            $output[] = [
                'id' => $subArray['id'],
                'title' => $subArray['name']
            ];
            if($subArray['children_recursive']) {
                $output[$key]['subs'] = makeList($subArray['children_recursive'] );
            }
		}
		
		return $output;
	}
  
  // define the init-function on the wrapper
  $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitDropDownComboTree';
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

    <input type="text" 
     @include('crud::fields.inc.attributes')
     />

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

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
    <link rel="stylesheet" href="/assets/admin/packages/drop-down-combo-tree/style.css">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="/assets/admin/packages/drop-down-combo-tree/comboTreePlugin.js"></script>
        <script>
            function bpFieldInitDropDownComboTree(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                var select_input = element.find('input[type=text]');
                var source = @json($source_array);
                
                let combo = @json($field['combo']);
                
                jQuery(document).ready(function($) {
                    
                        comboTree3 = select_input.comboTree({
                            source : source,
                            isMultiple : combo.isMultiple,
                            cascadeSelect : combo.cascadeSelect,
                            collapse : combo.collapse,
                            selectableLastNode : combo.selectableLastNode,
                            selected: selected_options
                        });

                        comboTree3.setSource(source);

                        if(combo.isMultiple) {
                          
                          var checkboxes = element.find('input[type=checkbox]');

                          checkboxes.on('click', function () {
                              var $chk = $(this), $li = $chk.closest('li'), $ul, $parent;
                              if ($li.has('ul')) {
                                  $li.find(':checkbox').not(this).prop('checked', this.checked)
                              }
                              do {
                                  $ul = $li.parent();
                                  $parent = $ul.siblings(':checkbox');
                                  if ($chk.is(':checked')) {
                                      $parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0)
                                  } else {
                                      $parent.prop('checked', false)
                                  }
                                  $chk = $parent;
                                  $li = $chk.closest('li');
                              } while ($ul.is(':not(.someclass)'));
                          });
                           // when a checkbox is clicked
                          // set the correct value on the hidden input
                          checkboxes.closest('.selectable').click(function() {
  
                              var newValue = [];
  
                              checkboxes.each(function() {
                                  if ($(this).is(':checked')) {
                                  var id = $(this).parent().data('id');
                                  newValue.push(id);
                                  }
                              });
  
                              hidden_input.val(JSON.stringify(newValue));
  
                          });
                        } else {
                          
                          var option = element.find('li.ComboTreeItemChlid span');
  
  
                          // not multiple
                          option.click(function() {
  
                            var id = $(this).data('id');
  
                            hidden_input.val(id);
  
                          });
                        }

                });

                
                var checkboxes = element.find('input[type=checkbox]');
                // // var container = element.find('.row');

                // checkboxes.on('click', function () {
                //   var $chk = $(this), $li = $chk.closest('li'), $ul, $parent;
                //   if ($li.has('ul')) {
                //       $li.find(':checkbox').not(this).prop('checked', this.checked)
                //   }
                //   do {
                //       $ul = $li.parent();
                //       $parent = $ul.siblings(':checkbox');
                //       if ($chk.is(':checked')) {
                //           $parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0)
                //       } else {
                //           $parent.prop('checked', false)
                //       }
                //       $chk = $parent;
                //       $li = $chk.closest('li');
                //   } while ($ul.is(':not(.someclass)'));
                // });               
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
