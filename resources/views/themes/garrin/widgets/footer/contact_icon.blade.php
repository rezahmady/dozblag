<div class="st-actionContainer right-bottom " x-data="{
    open: false
}">
        @can('page update')
            <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-35px;right:0;" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        @endcan
	<div class="st-panel" x-show.transition="open" x-on:click.away="open = false" x-on:click="open = false">
		<div class="grid">
            @php
                $items = json_decode($widget->contact_list);
            @endphp
            @if ($items)
                @foreach ($items as $item)
                <a href="{{$item->link}}" target="{{$item->link}}" class="gridChild"><i class="{{$item->icon}}" aria-hidden="true"></i>{{{$item->text}}}</a>
                @endforeach
            @endif
        </div>
	</div>
	<div class="st-btn-container right-bottom" x-on:click="open = true">
		<div class="st-button-main" x-bind:class="{'rotateForward' : open}"><i class="la la-phone" aria-hidden="true"></i></div>
	</div>
</div>