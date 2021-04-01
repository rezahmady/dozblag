<!-- filepond File Upload Field for Backpack for Laravel  -->
{{-- 
    Author: Reza Ahmadi sabzevar 
--}}
@php

    $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? "[]";

    // $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitFilepondElement';
@endphp

@include('crud::fields.inc.wrapper_start')
@include('crud::fields.inc.translatable_icon')
    <!-- We'll transform this input into a pond -->
    <input type="file"
     name="file"
     value="{{ $field['value'] }}"
     data-init-function="bpFieldInitFilepondElement"
     class="filepond">
    {{-- <input type="file" 
       class="filepond"
       name="filepond"
       accept="image/png, image/jpeg, image/gif"/> --}}
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
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <!-- Add plugin styles -->
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
        /*
        * FilePond Custom Styles
        */

        .filepond--drop-label {
            color: #4c4e53;
        }

        .filepond--label-action {
            text-decoration-color: #babdc0;
        }

        .filepond--panel-root {
            background-color: #edf0f4;
        }

    </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <!-- add the Image Crop plugin script -->
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>


    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    
        <script>

            function bpFieldInitFilepondElement(element) {

                FilePond.registerPlugin(
                    // register the Image Crop plugin with FilePond
                    FilePondPluginImageCrop,
                    FilePondPluginImagePreview,
                    FilePondPluginImageResize,
                    FilePondPluginImageTransform
                );
                // const inputElement = element.querySelector('input[type="file"]');
                // const pond = FilePond.create( inputElement );


                FilePond.parse(document.body);
                FilePond.setOptions({
                    server: {
                        url: '/filepond/api',
                        process: '/process',
                        revert: '/process',
                        headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                });

            }


        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}