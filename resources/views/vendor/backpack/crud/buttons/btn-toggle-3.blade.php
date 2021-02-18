
	{{-- <a href="{{ url($crud->route.'/setting') }}" class="btn btn-secondary" data-style="zoom-in"><span class="ladda-label"><i class="la la-cog"></i> </span></a> --}}

    <div class="btn-toggle">
        <div class="switch-toggle switch-3 switch-candy">

            <input id="on" name="state-d" type="radio" checked="" />
            <label for="on" onclick="">ON</label>
          
            <input id="na" name="state-d" type="radio" checked="checked" />
            <label for="na" class="disabled" onclick="">N/A</label>
          
            <input id="off" name="state-d" type="radio" />
            <label for="off" onclick="">OFF</label>
          
          </div>
    </div>
    <style type="text/css">
        .btn-toggle {
            display: inline;
        }
        .switch-toggle {
            float: left;
            background: #242729;
        }
        .switch-toggle input {
            position: absolute;
            opacity: 0;
        }
        .switch-toggle input + label {
            padding: 7px;
            float:left;
            color: #fff;
            cursor: pointer;
        }
        .switch-toggle input:checked + label {
            background: green;
        }
    </style>