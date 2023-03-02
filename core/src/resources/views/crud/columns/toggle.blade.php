{{-- toggle --}}
@php
    $value = data_get($entry, $column['name']);
    $checked = ($value == 1) ? 'checked' : '';
@endphp

<input type="checkbox" class="toggle" data-id="{{ $entry->id }}" {{ $checked }}>

@push('after_scripts')
<script>
    $(document).ready(function() {
        $('.toggle').change(function() {
            var id = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '{{ url($crud->route) }}/' + id + '/toggle',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    value: value
                },
                success: function(data) {
                    // do something if you want
                }
            });
        });
    });
</script>
@endpush