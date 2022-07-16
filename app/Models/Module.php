<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Module extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'versoin', 'description', 'status'];

    public function enable() {
        if($this->status) {
            return '<a class="btn btn-sm btn-link" href="'.url('admin/module/'.$this->id.'/disable').'" >غیرفعال کردن</a>';
        }else {
            return '<a class="btn btn-sm btn-link" href="'.url('admin/module/'.$this->id.'/enable').'" >فعال کردن</a>';
        }
    }

    public function disable() {
        $this->update(['status' => false]);
        Artisan::call('module:disable '.$this->name);
    }
}
