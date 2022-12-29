
<div id="timeline">
@foreach($revisions as $revisionDate => $dateRevisions)
      <h5 class="text-primary">
        {{-- {{ Carbon\Carbon::parse($revisionDate)->isoFormat(config('backpack.base.default_date_format')) }} --}}
        @php
            $v = new Verta($revisionDate);
            $class = new \ReflectionClass($crud->model);
            $namespace = $class->getNamespaceName();
            $module_name = false;
            if(Str::startsWith($namespace, 'Modules')) {
              $module_name = explode("\\", $namespace)[1];
              $module = Module::find($module_name);
              $module_name = $module->getLowerName();
            }
        @endphp
        {{ $v->format('Y/n/j') }}
      </h5>

  @foreach($dateRevisions as $history)
    <div class="card timeline-item-wrap">
      @php
        $v = new Verta($history->created_at);
        if($history->key === 'extras') {
            $json_field = true;

            $extra_old_value = json_decode($history->old_value, true);
            $extra_new_value = json_decode($history->new_value, true);

            $old_value = array_map('unserialize',
            array_diff(array_map('serialize', $extra_old_value), array_map('serialize', $extra_new_value)));


            $new_value = array_map('unserialize',
            array_diff(array_map('serialize',$extra_new_value ), array_map('serialize',$extra_old_value )));

            $values = [];
            foreach ($new_value as $key => $value) {
                $values[$key] = [
                    'old' => $old_value[$key] ?? '',
                    'new' => $value
                ];
            }
            $values = \TorMorten\Eventy\Facades\Events::filter('core-revision-timeline-fields', $values);
        } else {
            $json_field = false;
        }



      @endphp
      @if($history->key == 'created_at' && !$history->old_value)
        <div class="card-header">
          <strong class="time"><i class="la la-clock"></i> {{ $v->format('h:ia') }}</strong> -
          {{ $history->userResponsible()?$history->userResponsible()->name:trans('revise-operation::revise.guest_user') }} {{ trans('revise-operation::revise.created_this') }} {{ $crud->entity_name }}
        </div>
      @else
        <div class="card-header">
          <strong class="time"><i class="la la-clock"></i>  {{ $v->format('H:i') }}</strong> -
          {{ trans('revise-operation::revise.changed_the') }} <b> @if($module_name) {{ trans("$module_name::$module_name.".$history->fieldName()) }} @else  {{ trans('backpack::revise.attributes.'.$history->fieldName()) }} @endif </b> توسط <a href="{{backpack_url("user/".$history->userResponsible()->id."/edit")}}">{{ $history->userResponsible()?$history->userResponsible()->name:trans('revise-operation::revise.guest_user') }}</a>
          <div class="card-header-actions">
            <form class="card-header-action" method="post" action="{{ url(\Request::url().'/'.$history->id.'/restore') }}">
              {!! csrf_field() !!}
              <button type="submit" class="btn btn-outline-danger btn-sm restore-btn" data-entry-id="{{ $entry->id }}" data-revision-id="{{ $history->id }}" onclick="onRestoreClick(event)">
                <i class="la la-undo"></i> {{ trans('revise-operation::revise.undo') }}</button>
              </form>
          </div>
        </div>
        <div class="card-body">
            @if($json_field)
                @foreach($values as $key => $value)
                    <div class="row">
                        <div class="col-md-6">{{ mb_ucfirst(trans('revise-operation::revise.from')) }} {!! $key !!}:</div>
                        <div class="col-md-6">{{ mb_ucfirst(trans('revise-operation::revise.to')) }} {!! $key !!}:</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="alert alert-danger" style="overflow: hidden;">{!! $value['old'] !!}</div></div>
                        <div class="col-md-6"><div class="alert alert-success" style="overflow: hidden;">{!! $value['new'] !!}</div></div>
                    </div>
                @endforeach

            @else
              <div class="row">
                <div class="col-md-6">{{ mb_ucfirst(trans('revise-operation::revise.from')) }}:</div>
                <div class="col-md-6">{{ mb_ucfirst(trans('revise-operation::revise.to')) }}:</div>
              </div>
              <div class="row">
                <div class="col-md-6"><div class="alert alert-danger" style="overflow: hidden;">{{ $history->oldValue() }}</div></div>
                <div class="col-md-6"><div class="alert alert-success" style="overflow: hidden;">{{ $history->newValue() }}</div></div>
              </div>
            @endif
        </div>
      @endif
    </div>
  @endforeach
@endforeach
</div>

@section('after_scripts')
  <script type="text/javascript">
    $.ajaxPrefilter(function(options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
              return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });
    function onRestoreClick(e) {
      e.preventDefault();
      var entryId = $(e.target).attr('data-entry-id');
      var revisionId = $(e.target).attr('data-revision-id');
      $.ajax('{{ url(\Request::url()).'/' }}' +  revisionId + '/restore', {
        method: 'POST',
        data: {
          revision_id: revisionId
        },
        success: function(revisionTimeline) {
          // Replace the revision list with the updated revision list
          console.log(revisionTimeline);
          $('#timeline').replaceWith(revisionTimeline);

          // Animate the new revision in (by sliding)
          $('.timeline-item-wrap').first().addClass('fadein');

          // Show a green notification bubble
          new Noty({
              type: "success",
              text: "{{ trans('revise-operation::revise.revision_restored') }}"
          }).show();
        },
        error: function(data) {
          // Show a red notification bubble
          new Noty({
              type: "error",
              text: data.responseJSON.message
          }).show();
        }
      });
  }
  </script>
@endsection

@section('after_styles')
  {{-- Animations for new revisions after ajax calls --}}
  <style>
     .timeline-item-wrap.fadein {
      -webkit-animation: restore-fade-in 3s;
              animation: restore-fade-in 3s;
    }
    @-webkit-keyframes restore-fade-in {
      from {opacity: 0}
      to {opacity: 1}
    }
      @keyframes restore-fade-in {
        from {opacity: 0}
        to {opacity: 1}
    }
  </style>
@endsection
