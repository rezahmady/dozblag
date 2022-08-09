<!-- CKeditor -->
@php
    $field['extra_plugins'] = isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : "embed,widget";

    $defaultOptions = [
        "filebrowserBrowseUrl" => backpack_url('elfinder/ckeditor'),
        "extraPlugins" => $field['extra_plugins'],
        "embed_provider" => "//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}",
    ];

    $field['options'] = array_merge($defaultOptions, $field['options'] ?? []);
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <textarea
        name="{{ $field['name'] }}"
        data-init-function="bpFieldInitLarabergElement"
        data-options="{{ trim(json_encode($field['options'])) }}"
        id="guttenberg-{{ $field['name'] }}"
        @include('crud::fields.inc.attributes', ['default_class' => 'form-control'])
    	>{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>

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
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    
        <script>
            const mediaUpload = ({filesList, onFileChange}) =>  {
                setTimeout(async () => {
                    const uploadedFiles =  Array.from(filesList).map((file) => {
                        let data = new FormData();
                        data.append('file', file);
                        const prefix = (new Date()).getTime();
                        data.append('prefix', prefix);
                        console.log('ddd');

                        axios.post('/admin/upload/file',data).then(res => {
                            console.log(res.data)
                        });

                        return {
                            id: prefix+file.name,
                            name: prefix+file.name,
                            url:  `/uploads/${prefix+file.name}`
                        }

                    })
                    onFileChange(uploadedFiles)
                }, 1000)
            }

            function bpFieldInitLarabergElement(element) {
                Laraberg.init('guttenberg-{{ $field['name'] }}', { mediaUpload });
            }
        </script>
    @endpush

@endif

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
