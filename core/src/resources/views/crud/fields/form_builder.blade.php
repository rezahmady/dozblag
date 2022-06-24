<!-- Form Builder Field for Backpack for Laravel  -->
{{-- 
    Author: Reza Ahmadi sabzevar 
--}}
@php

    $field['value'] = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? "[]";

    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitFormBuilderElement';

    $ostans = \App\Models\Ostan::pluck('name', 'id')->toArray();
@endphp

@include('crud::fields.inc.wrapper_start')
@include('crud::fields.inc.translatable_icon')
    <input type="hidden" name="{{ $field['name'] }}" value="{{ $field['value'] }}">
    <div class="filter-controls">
       <input type="text" class="form-control mb-3" id="control-filter" placeholder="جستجو فیلد ..." />
    </div>
    <div class="formeo-editor" dir="ltr"
    ></div>
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
    <link rel="stylesheet" href="/assets/admin/packages/formeo/formeo.min.css">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="/assets/admin/packages/formeo/formeo.min.js"></script>
        <script>
            
            function bpFieldInitFormBuilderElement(element) {

                editor = element.find('.formeo-editor')[0];
                data = JSON.parse(@json($field['value']));
                
                const options = {
                    editorContainer: editor,
                    // svgSprite: 'https://draggable.github.io/formeo/assets/img/formeo-sprite.svg',
                    dataType: 'json',
                    formData: data,
                    i18n: {
                        extension: '.lang',
                        location: '/assets/admin/packages/formeo/lang',
                        langs: ['fa-IR', 'en-US'],
                        locale: 'fa-IR',
                        override: {
                            'hu-HU': {
                                // save: 'Siker'
                            }
                        }
                    },
                    
                    controls: {
                        groups: [
                            {
                                id: 'default',
                                label: 'فیلدهای آماده',
                                // elementOrder: ['myelement'],
                            },
                            {
                                id: 'common',
                                label: 'فیلدهای اختصاصی',
                                // elementOrder: ['myelement'],
                            },
                            {
                                id: 'html',
                                label: 'المنت‌های Html',
                                // elementOrder: ['myelement'],
                            },
                            {
                                id: 'layout',
                                label: 'چینش',
                                // elementOrder: ['myelement'],
                            },
                            
                        ],
                        groupOrder: ['common', 'default', 'html', 'layout'],
                        disable: {
                            // elements: ['number'],
                            // groups: ['layout'],
                            // formActions: true, // cancel and save buttons will not be shown
                            formActions: ['saveBtn'], // only the clear button will be disabled
                        },
                        elements: [
                            {
                                tag: 'input',
                                attrs: {
                                    type: 'number',
                                    className: 'form-control'
                                },
                                config: {
                                    label: 'Price'
                                },
                                meta: {
                                    group: 'default',
                                    icon: 'text-input',
                                    id: 'price-input'
                                }
                            },
                            {
                                tag: 'select', // HTML tag used to render the element
                                config: {
                                    label: 'استان',
                                    disabledAttrs: ['type'], // Attributes hidden from the user
                                    lockedAttrs: [], // Attributes that cannot be deleted
                                },
                                meta: {
                                    group: 'default',
                                    id: 'ostan',
                                    icon: '<i class="la la-map-marker"></i>', // Icon name in icon set
                                },
                                attrs: {
                                    // actual attributes on the HTML element, and their default values
                                    type: 'select', // type field is important if tag==input
                                    name: 'ostan',
                                },
                                options: [
                                    // Used for element types like radio buttons
                                    {label: 'تهران', value: 'opt1', selected: true},
                                    {label: 'مشهد', value: 'opt2', selected: false},
                                    {label: 'اصفهان', value: 'opt3', selected: false},
                                    {label: 'خرم‌آباد', value: 'opt4', selected: false},
                                ],
                            },
                            {
                                tag: 'select', // HTML tag used to render the element
                                config: {
                                    label: 'شهرستان',
                                    disabledAttrs: ['type'], // Attributes hidden from the user
                                    lockedAttrs: [], // Attributes that cannot be deleted
                                },
                                meta: {
                                    group: 'default',
                                    id: 'email',
                                    icon: '<i class="la la-map-marker"></i>', // Icon name in icon set
                                },
                                attrs: {
                                    // actual attributes on the HTML element, and their default values
                                    type: 'select', // type field is important if tag==input
                                    name: 'shahrestan',
                                },
                                options: [
                                    // Used for element types like radio buttons
                                    {label: 'ابتدا استان خود را انتخاب کنید', value: '', selected: true},
                                ],
                            },
                        ]
                    }
                }
                
                // Set up a form builder
                const formeo = new FormeoEditor(options)
    
                // When you're ready, grab the form data object
                // Typically you'd do this in the "onSave" event, which you can configure through the editor's options object
                const formData = formeo.formData
    
            
                // Then, when you're ready to render the form, use
                // const renderer = new FormeoRenderer(options)
                // renderer.render(formData)
                // element will be a jQuery wrapped DOM node
                document.getElementById('control-filter').addEventListener('input', function(e) {
                    formeo.controls.actions.filter(e.target.value);
                });
                document.querySelector("#saveActions").addEventListener('click', function() {
                    console.log(formData);
                    element.find('input[type=hidden]').val(JSON.stringify(formeo.formData))
                })

            }


        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}