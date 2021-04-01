<!-- checklist -->
@php

  $model = new $field['model'];
  $key_attribute = $model->getKeyName();
  $identifiable_attribute = $field['attribute'];

  $pages = $field['model']::where(['parent_id' => null, 'template' => $field['template']])->with('childrenRecursive')->select('id','name')->get()->toArray();

  // calculate the value of the hidden input
  $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
  
  if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
    $field['value'] = $field['value']->pluck($key_attribute)->toArray();
  } elseif (is_string($field['value'])){
    $field['value'] = json_decode($field['value']);
  }
  $nested_checkelist = makeList($pages);
  
  function makeList($array, $id = false) {
    
		//Base case: an empty array produces no list
    if (empty($array)) return ;
    
    $attr = ($id) ? ' id="collapse'.$id.'" class="collapse" aria-labelledby="heading'.$id.'"'  : '';
    $classMain = ($id) ? 'list-group collapse' : 'row';
    $classCol = ($id) ? '' : 'm-1';
		//Recursive Step: make a list with child lists
		$output = '<ul class="'.$classMain.'" '.$attr.'>';
		foreach ($array as $key => $subArray) {
            $has_child = (empty($subArray['children_recursive'])) ? '' : 'btn-link';
            $output .= '<div class="'.$classCol.'"><li class="list-group-item list-group-item-action '.$has_child.'">
            <input value="'.$subArray['id'].'" type="checkbox" name="'.$subArray['name'].'">
            <label class="collapsed"
            for="'.$subArray['name'].'" data-toggle="collapse" 
            aria-expanded="true"
            data-target="#collapse'.$subArray['id'].'"
            >'.$subArray['name'].'</label>' 
            . makeList($subArray['children_recursive'], $subArray['id'] ) . '</li></div>';
		}
		$output .= '</ul>';
		
		return $output;
	}
  
  // define the init-function on the wrapper
  $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklistNested';
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

    <div class="row checklist-nested">

        {!! $nested_checkelist !!}

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

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
    <style>
      .checklist-nested ul { 
        list-style: none;
        margin: 5px 20px;
      }
      .checklist-nested li {
        margin: 10px 0;
      }
      .checklist-nested .list-group-item label {
        padding-left: .75rem;
      }

      .checklist-nested .list-group-item {
        border: 3px dotted rgba(22,28,45,.125);
        background: rgba(0,0,0,.02);
      }

      .checklist-nested .list-group-item.btn-link {
        cursor: pointer !important;
      }

      .checklist-nested .list-group-item.btn-link > label:before {
          position: absolute;
          top: 25px;
          right: 1rem;
          display: block;
          width: 8px;
          height: 8px;
          padding: 0;
          margin-top: -4px;
          content: "";
          background: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 11 14'%3E%3Cpath fill='%23869AB8' d='M9.148 2.352l-4.148 4.148 4.148 4.148q0.148 0.148 0.148 0.352t-0.148 0.352l-1.297 1.297q-0.148 0.148-0.352 0.148t-0.352-0.148l-5.797-5.797q-0.148-0.148-0.148-0.352t0.148-0.352l5.797-5.797q0.148-0.148 0.352-0.148t0.352 0.148l1.297 1.297q0.148 0.148 0.148 0.352t-0.148 0.352z'/%3E%3C/svg%3E");
          background-repeat: no-repeat;
          background-position: 50%;
          transition: transform .3s;
      }

      [dir=rtl] .checklist-nested .list-group-item.btn-link > label:before {
        position: absolute;
        right: auto;
        left: 1rem;
        transform: rotate(180deg);
      }



      [dir=rtl] .checklist-nested .list-group-item.btn-link > label.collapsed:before {
          transform: rotate(270deg);
      }

    </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function bpFieldInitChecklistNested(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                
                var checkboxes = element.find('input[type=checkbox]');
                // var container = element.find('.row');

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



                // set the default checked/unchecked states on checklist options
                checkboxes.each(function(key, option) {
                  var id = $(this).val();

                  if (selected_options.map(String).includes(id)) {
                    $(this).prop('checked', 'checked');
                    // $(this).parent().parent().parent().addClass('show')
                    $(this).parents('.list-group.collapse').each(function() {
                      $(this).addClass('show')
                      //  $(this).find('.collaps').removeClass('collapsed')
                      // $(this).first('label').addClass('collapsed22')
                      // console.log()
                      
                    });

                    $(this).parents('label.collapsed').each(function() {
                      $(this).removeClass('collapsed')
                    });
                  } else {
                    $(this).prop('checked', false);
                  }
                });

                // when a checkbox is clicked
                // set the correct value on the hidden input
                checkboxes.click(function() {
                  var newValue = [];

                  checkboxes.each(function() {
                    if ($(this).is(':checked')) {
                      var id = $(this).val();
                      newValue.push(id);
                    }
                  });

                  hidden_input.val(JSON.stringify(newValue));

                });
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
