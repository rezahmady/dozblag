<!-- iranian_plates_number -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <div data-init-function="bpFieldInitIranianPlatesNumber">
        <input
            type="hidden"
            name="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            
        >
        <div class="iranian_plates_number" @include('crud::fields.inc.attributes')>
            <div class="right">
                <span>ایران</span>
                <input
                    min="10" max="99" pattern="[10-99]{2}" maxlength="2"
                    type="number"
                    name="section1"
                    class="section section1"
                >
            </div>
            <input
                type="number"
                min="100" max="999"
                class="section section2"
                name="section2"
            >
            <select name="section3" id=""
            class="section section3"
            >
                <option value="ب">ب</option> 
                <option value="ج">ج</option> 
                <option value="د">د</option> 
                <option value="س">س</option> 
                <option value="ص">ص</option>
                <option value="ط">ط</option> 
                <option value="ق">ق</option> 
                <option value="ل">ل</option> 
                <option value="م">م</option> 
                <option value="ن">ن</option> 
                <option value="ه">ه</option> 
                <option value="و">و</option> 
                <option value="ی">ی</option> 
                <option value="ع">ع</option>
                <option value="ژ">ژ</option>
                <option value="ی/ب">ی/ب</option>
                <option value="د/ه">د/ه</option>
            </select>
            
            <input
                type="number"
                min="10" max="99"
                class="section section4"
                name="section4"
            >
    
            <div class="left">
                <img src="{{asset('/modules/unity/img/OIP.jpg')}}" alt="">
                <span>
                    <span>I.R.</span>
                    <span>IRAN</span>
                </span>
            </div>
    
        </div>
    </div>

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
        <!-- no styles -->
        <style>
            .iranian_plates_number {
                display: flex;
                align-items: center;
                border: 2px solid;
                border-radius: 5px;
                justify-content: space-between;
            }

            .iranian_plates_number .right {
                border-left: 2px solid;
                font-weight: 600;
                text-align: center;
                width: 45px;
                height: 63px;
            }

            .iranian_plates_number .left {
                background-color: #0242af;
                color: white;
                text-align: center;
                width: 45px;
                height: 63px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 3px;
            }

            .iranian_plates_number .left img {
                margin: auto;
            }

            .iranian_plates_number .left span {
                font-size: 12px;
                font-weight: 600;
                text-align: left;
            }

            .iranian_plates_number .section {
                font-size: 20px;
                font-weight: 600;
                text-align: center;
            }

            /* Chrome, Safari, Edge, Opera */
            .iranian_plates_number .section::-webkit-outer-spin-button,
            .iranian_plates_number .section::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            /* Firefox */
            .iranian_plates_number .section[type=number] {
            -moz-appearance: textfield;
            }

            .iranian_plates_number .section1 {
                border: 0;
                height: 35px;
                width: 35px;
                background: #eaf2f9;
                border-radius: 10px;
            }

            .iranian_plates_number .section2 {
                border: 0;
                height: 40px;
                width: 60px;
                background: #eaf2f9;
                border-radius: 10px;
            }

            .iranian_plates_number .section3 {
                border: 0;
                height: 40px;
                width: 60px;
                background: #eaf2f9;
                border-radius: 10px;
                padding: 3px;
            }

            .iranian_plates_number .section4 {
                border: 0;
                height: 40px;
                width: 45px;
                background: #eaf2f9;
                border-radius: 10px;
            }
            

        </style>
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script>
            function bpFieldInitIranianPlatesNumber(element) {
                var hidden_input = element.find('input[type=hidden]');
                var hidden_input_value = hidden_input.val();
                var sections = element.find('.section');

                values = hidden_input_value.split('-');

                if(values.length == 4) {
                    element.find('.section1').eq(0).val(values[0])
                    element.find('.section2').eq(0).val(values[1])
                    element.find('.section3').eq(0).val(values[2])
                    element.find('.section4').eq(0).val(values[3])
                }

                sections.change(function() {
                  var newValue = [];

                  sections.each(function() {
                    var id = $(this).val();
                    console.log(id)
                    newValue.push(id);
                  });

                  hidden_input.val(newValue.join('-')).trigger('change');

                });

            }
        </script>
    @endpush
@endif