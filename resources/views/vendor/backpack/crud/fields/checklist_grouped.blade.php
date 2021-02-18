<!-- checklist -->
@php
  $model = new $field['model'];
  $key_attribute = $model->getKeyName();
  $identifiable_attribute = $field['attribute'];
  
  // calculate the checklist options
  if (!isset($field['options'])) {
    // $field['options'] = $field['model']::all()->pluck($identifiable_attribute, $key_attribute)->toArray();
      $list = $field['model']::all()->toArray();
      $fields_list = [];
      $fields_grouped = [];
      foreach ($list as $item) {

          $myvalue = $item['name'];
          $arr = explode(' ',trim($myvalue));
          $fields_list[$item[$key_attribute]] = [
            'group' => $arr[0],
            $identifiable_attribute => $item[$identifiable_attribute]
          ];
      }

      foreach ($fields_list as $key => $item) {
        $field_groued[$item['group']][$key] = $item[$identifiable_attribute];
      }
      $field['options'] = $field_groued;
  } else {
      $field['options'] = call_user_func($field['options'], $field['model']::query());
  }

  // calculate the value of the hidden input
  $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? [];
  if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection) {
    $field['value'] = $field['value']->pluck($key_attribute)->toArray();
  } elseif (is_string($field['value'])){
    $field['value'] = json_decode($field['value']);
  }


  // define the init-function on the wrapper
  $field['wrapper']['data-init-function'] =  $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';
@endphp

@include('crud::fields.inc.wrapper_start')
    {{-- <label>{!! $field['label'] !!}</label> --}}
    @include('crud::fields.inc.translatable_icon')

    <input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">

    <div class="row">
      @foreach ($field['options'] as $gkey => $group)
      <div class="col-sm-4">
        <div class=" checklist_grouped_box">
          <span class="checklist_grouped_title d-flex align-items-center">
            <i class="before-header"></i>
          <div class="text">{{trans("backpack::permissionmanager.attribute.$gkey")}}</div></span>
          @foreach ($group as $key => $option)
              <div class="">
                  <div class="checkbox">
                    <label class="font-weight-normal">
                      <input type="checkbox" value="{{ $key }}"> {{ $option }}
                    </label>
                  </div>
              </div>
          @endforeach
        </div>
      </div>
      @endforeach
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
    @push('crud_fields_styles')
    <style>
      .checklist_grouped_title {
        font-size: 17px;
        /* border-right: 3px solid #8bc34a; */
        margin-bottom: 5px;
        display: block;
        margin-right: -5px;
      }

      .checklist_grouped_title .before-header {
        height: 20px;
        width: 5px;
        background-color: #8bc34a;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
        position: relative;
      }

      .checklist_grouped_box {
        background-image: linear-gradient(180deg,#f9f9f9 10%,#fff 92%);
        border-radius: 10px;
        padding: 5px;
        margin-bottom: 15px;
      }
      .checklist_grouped_title .text {
        padding-right: 1rem;
        color: #924d8b;
      }
    </style>
    @endpush
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function bpFieldInitChecklist(element) {
                var hidden_input = element.find('input[type=hidden]');
                var selected_options = JSON.parse(hidden_input.val() || '[]');
                var checkboxes = element.find('input[type=checkbox]');
                var container = element.find('.row');

                // set the default checked/unchecked states on checklist options
                checkboxes.each(function(key, option) {
                  var id = $(this).val();

                  if (selected_options.map(String).includes(id)) {
                    $(this).prop('checked', 'checked');
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
