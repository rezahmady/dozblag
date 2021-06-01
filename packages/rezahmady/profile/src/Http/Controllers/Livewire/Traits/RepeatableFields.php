<?php
namespace Rezahmady\Profile\Http\Controllers\Livewire\Traits;


trait RepeatableFields
{
    public function addRepeatableItems($field)
    {
        $this->{$field}[] = $this->{$field}();
    }

    public function removeRepeatableItems($key, $field)
    {
        $this->{$field} = array_values(array_filter($this->{$field}, function ($k) use ($key) {
            return $key != $k;
        },ARRAY_FILTER_USE_KEY));
    }
}