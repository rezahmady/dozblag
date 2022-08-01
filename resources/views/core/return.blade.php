@extends(backpack_view('blank'))

@section('content')

<style>
    .app-header {
        display: none;
    }
</style>


@endsection

@section('before_scripts')
<script>
    var event = new CustomEvent('widgetupdatemodalclose')
    window.parent.window.dispatchEvent(event);
</script>
@endsection