@foreach ($filters as $filter)
    <div class="filter-widget p-0 mb-0" <div class="filter-widget p-0 mb-0" x-data="{items: false}" x-ref="{{$filter->slug}}">
        <h4 class="font-weight-bold d-flex justify-between" x-on:click="items = !items" x-bind:class="{ 'active': items }">
            <span>{{$filter->name}}</span>
            <i class="la" x-bind:class="{'la-plus' : !items, 'la-minus' : items}"></i>
        </h4>
        <div class="filter-holder transition-all" x-show="items">
            @foreach ($filter->items->sortBy('rgt') as $item)
            <div>
                <label class="custom_check">
                    <input type="checkbox" wire:model="filter.{{$filter->slug}}.{{$item->id}}">
                    <span class="checkmark"></span> {{$item->name}}
                </label>
            </div>
            @endforeach
        </div>
    </div>
@endforeach