@php
    $value = data_get($entry, $column['name']);
    $column['prefix'] = $column['prefix'] ?? '';
    $column['disk'] = $column['disk'] ?? null;
    $column['escaped'] = $column['escaped'] ?? true;
    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
    $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
    $column_wrapper_href = $column['wrapper']['href'] ?? function($file_path, $disk, $prefix) { return ( !is_null($disk) ?asset(\Storage::disk($disk)->url($file_path)):asset($prefix.$file_path) ); }
@endphp

<span class="d-flex justify-content-center flex-wrap">
    @if ($value && count($value))
        <div class="d-flex justify-content-center flex-wrap">
        @foreach ($value as $file_path)
            @php
                $column['wrapper']['href'] = is_callable($column_wrapper_href) ? $column_wrapper_href($file_path, $column['disk'], $column['prefix']) : $column_wrapper_href;
                $text = $column['prefix'].$file_path;
            @endphp
            <img width="200px" class="m-2" src="/{{$file_path}}" />
        @endforeach
        </div>
    @endif
</span>
