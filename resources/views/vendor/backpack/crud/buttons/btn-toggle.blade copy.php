
	{{-- <a href="{{ url($crud->route.'/setting') }}" class="btn btn-secondary" data-style="zoom-in"><span class="ladda-label"><i class="la la-cog"></i> </span></a> --}}

    <div class="btn-toggle">
        <label class="switch">
            <input type="hidden" name="vv" value="0">
            <input type="checkbox" 
                value="1"
                name="vv"
                
                {{-- data-init-function="bpFieldInitToggleElement" --}}

                {{-- @if (old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? false) --}}
                checked="checked"
                {{-- @endif --}}

            >
            <span class="slider round"></span>

        
    </div>
    <style type="text/css">
        .btn-toggle {
            display: inline;
        }
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 3em;
            height: 1.5em;
            margin-right: 5px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 1em;
            width: 1em;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #467FD0;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #467FD0;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>