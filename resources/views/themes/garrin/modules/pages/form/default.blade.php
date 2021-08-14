@push('custom-style')
    <link rel="stylesheet" href="/packages/formeo/formeo.min.css">
    <style>
                
        .formeo.formeo-editor .formeo-field .prev-label {
            margin-right: 24px;
        }
        
        .formeo-field {
            direction: rtl;
        }
        
        .formeo .panels {
            direction: ltr !important;
        }
        
        .formeo.formeo-editor .editing-field {
            background-color: #f1f4f8 !important;
        }
        
        .formeo.formeo-editor .editing-field,
        .formeo.formeo-editor .hovering-field {
            box-shadow: inset 0 0 0 1px #e7eaee !important;
            background: #f3f4fa !important;
        }
        
        .tabbed-panels .panel-labels h5 {
            box-shadow: none !important;
        }
        
        .tabbed-panels .panel-labels h5.active-tab {
            color: #676767 !important;
            box-shadow: none;
            background-color: #fff !important;
        }
        
        .field-control,
        .formeo-controls .field-control {
            /* border: 1px solid #e7eaee !important; */
            color: #fff;
            background: #ffc107 linear-gradient(180deg, #eceff3 80%, #e2e7ef 100%) repeat-x !important;
            border-color: #e2e5e9 !important;
        }
        
        .formeo.formeo-editor .formeo-row {
            box-shadow: inset 0 0 0 1px #e7eaee !important;
        }
        
        .formeo.formeo-editor .row-actions {
            border: 1px solid #e7eaee !important;
        }
        
        .tabbed-panels .panel-labels h5 {
            background-color: #f3f4fa !important;
        }
        
        .formeo button.prop-remove.prop-control {
            color: #fff;
            background: #fb4646 linear-gradient(180deg, #fb4a4a 80%, #dc2828 100%) repeat-x !important;
            box-shadow: 0 5px 15px rgba(99, 146, 242, 0.25) !important;
            border-color: #d42d2d !important;
        }
        
        .formeo button.prop-remove.prop-control .svg-icon {
            fill: #fff;
        }
        
        button[class*=-remove]:hover {
            color: #fff;
            background: #fb4646 linear-gradient(180deg, #fb4a4a 80%, #dc2828 100%) repeat-x !important;
            box-shadow: 0 5px 15px rgba(99, 146, 242, 0.25) !important;
            border-color: #d42d2d !important;
        }
        
        button[class*=-edit-toggle]:hover {
            background: #4dc5ff linear-gradient(180deg, #5ac8fd 80%, #3eb6e4 100%) repeat-x !important;
            box-shadow: 0 5px 15px rgba(99, 146, 242, 0.25) !important;
            border-color: #4bbbf0 !important;
            color: #fff !important;
        }
        
        button[class*=-edit-toggle]:hover .svg-icon {
            fill: #fff !important;
        }
        
        .formeo.formeo-editor .panel-action-buttons [class^=add-] {
            float: right;
            background: #4dc5ff linear-gradient(180deg, #5ac8fd 80%, #3eb6e4 100%) repeat-x !important;
            box-shadow: 0 5px 15px rgba(99, 146, 242, 0.25) !important;
            border-color: #4bbbf0 !important;
            color: #fff !important;
        }
        
        .formeo button.clear-form {
            color: #fff;
            background: #ffc107 linear-gradient(180deg, #ffc107 80%, #eab106 100%) repeat-x !important;
            box-shadow: 0 5px 15px rgba(139, 195, 74, 0.25) !important;
            border-color: #f3b704 !important;
        }
        
        .formeo-controls nav button {
            background: #f1f4f8 !important;
            border-color: #f1f4f8 !important;
        }
        
        .formeo-panels-wrap h5 {
            color: #3e3e3f !important;
            background: #f1f4f8 !important;
            font-size: 17px !important;
        }
        
        .formeo-controls .panel-labels {
            border-top: 0px !important;
            border-radius: 0 !important;
        }
        
        .formeo-field p,
        .formeo-field h1,
        .formeo-field h2 {
            text-align: right;
            margin-right: 24px;
            float: right;
        }
        
        .formeo.formeo-editor .formeo-stage {
            margin-right: 15px !important;
        }
        
        .formeo.formeo-editor .formeo-column.editing-column,
        .formeo.formeo-editor .formeo-column.hovering-column {
            box-shadow: inset 0 0 0 1px #fec109 !important;
        }
        
        .formeo.formeo-editor .formeo-column.editing-column:before,
        .formeo.formeo-editor .formeo-column.hovering-column:before {
            height: 23px;
            border-right: 1px solid #fec109 !important;
            border-left: 1px solid #fec109 !important;
            border-top: 1px solid #fec109 !important;
        }
        
        .formeo input[type=checkbox],
        .formeo input[type=radio] {
            margin-left: 4px;
            margin-top: 5px;
        }
        
        .formeo .f-checkbox {
            display: flex;
        }

        .formeo.formeo-render .formeo-column {
            padding-right: 0px;
            padding-left: 4px !important;
        }
    </style>
@endpush

<section class="contact-area pb-100 mt-3">
    
    <div class="container p-3">
        <div class="section-title">
            <h2>{{ $title }}</h2>
            {!! $entity->description !!}
        </div>

        <div class="contact-form">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif

            @if (\Session::has('error'))
                <div class="alert alert-warning">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
            @endif
            <form action="{{ route('form.save', $entity->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div id="form"></div>
            </form>
        </div>
    </div>

    <div id="particles-js-circle-bubble-3"></div>
</section>

@push('custom-script')
    <script >
        document.addEventListener("turbolinks:load", function() {
            data = JSON.parse(@json($form));
            
            const options = {
                renderContainer: '#form',
                svgSprite: 'https://draggable.github.io/formeo/assets/img/formeo-sprite.svg',
                dataType: 'json',
                formData: data
            }
                            
            const renderer = new FormeoRenderer(options)
            setTimeout(function(){ 
                renderer.render(data)
            }, 0);
        })
    </script>
@endpush