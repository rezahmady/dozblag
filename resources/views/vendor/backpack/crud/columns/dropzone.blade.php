@php
    $column['value'] = $column['value'] ?? data_get($entry, $column['name']);

    if (!is_array($column['value'])) {
      $column['value'] = json_decode($column['value']);
    }
@endphp


@if(empty($column['value']))
    {{ $column['default'] ?? '-' }}
@else
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    <div id="{{ $column['name'] }}-existing" class="dropzone dropzone-previews ">
        @if (isset($column['value']) && count($column['value']))
            @foreach($column['value'] as $key => $file_path)
                <div class="dz-preview dz-image-preview dz-complete text-center">
                    <input type="hidden" name="{{ $column['name'] }}[]" value="{{ $file_path }}" />
                    <div class="dz-image-no-hover">
                        @if (Str::endsWith($file_path, '.pdf'))
                            <a href="{{ asset('storage/' . $file_path) }}" data-toggle="modal" data-target="#pdfModal-{{ $key }}">
                                <img src="{{ asset('assets/admin/images/pdf-svgrepo-com.svg') }}" class="img-thumbnail" />
                            </a>
                        @else
                            <a href="{{ config('filesystems.disks.'.$column['disk'].'.url') .'/'. $column['destination_path'] .'/'. $column['thumb_prefix'] . basename($file_path) }}" data-toggle="modal" data-target="#imageModal-{{ $key }}">
                                <img src="{{ config('filesystems.disks.'.$column['disk'].'.url') .'/'. $column['destination_path'] .'/'. $column['thumb_prefix'] . basename($file_path) }}" class="img-thumbnail" />
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
@endif

@push('crud_fields_styles')
    <link rel="stylesheet" href="{{asset('/assets/admin/packages/dropzone/dropzone.min.css')}}" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropzone-target {
            background: #f3f3f3;
            border: 2px dashed #ddd;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: #999;
            font-size: 1.2em;
            padding: 2em;
        }

        .dropzone-previews {
            margin-top: 10px;
            padding: 2em;
            border: 0;
        }

        .dropzone.dz-drag-hover {
            background: #ececec;
            border-bottom: 2px dashed #999;
            border-left: 2px dashed #999;
            border-right: 2px dashed #999;
            color: #333;
        }

        .dz-message {
            text-align: center;
        }

        .dropzone .dz-preview .dz-image-no-hover {
            cursor: move;
            display: block;
            height: 120px;
            overflow: hidden;
            position: relative;
            width: 120px;
            z-index: 10;
        }
    </style>
@endpush

@push('crud_fields_scripts')
    @if (isset($column['value']) && count($column['value']))
        @foreach($column['value'] as $key => $file_path)
            @if (Str::endsWith($file_path, '.pdf'))
                <div class="modal fade" id="pdfModal-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel-{{ $key }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pdfModalLabel-{{ $key }}">پیش نمایش PDF</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <embed src="{{ asset($file_path) }}" type="application/pdf" width="100%" height="600px" />
                                <a href="{{ asset($file_path) }}" class="btn btn-primary mt-2" download>دانلود</a>
                                <button onclick="printPDF('{{ asset($file_path) }}')" class="btn btn-secondary mt-2">پرینت</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="modal fade" id="imageModal-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel-{{ $key }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel-{{ $key }}">پیش نمایش تصویر</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ config('filesystems.disks.'.$column['disk'].'.url') .'/'. $column['destination_path'] .'/'. $column['thumb_prefix'] . basename($file_path) }}" class="img-fluid" />
                                <a href="{{ config('filesystems.disks.'.$column['disk'].'.url') .'/'. $column['destination_path'] .'/'. $column['thumb_prefix'] . basename($file_path) }}" class="btn btn-primary mt-2" download>دانلود</a>
                                <button onclick="printImage('{{ config('filesystems.disks.'.$column['disk'].'.url') .'/'. $column['destination_path'] .'/'. $column['thumb_prefix'] . basename($file_path) }}')" class="btn btn-secondary mt-2">پرینت</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
@endpush
