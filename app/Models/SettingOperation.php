<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SettingOperation extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['key', 'fields'];
    // protected $hidden = [];
    // protected $dates = [];
    // public $translatable = ['name', 'caption', 'content', 'metas', 'settings', 'description', 'parameters', 'type_data'];
    protected $fakeColumns = ['fields'];
    public $casts = [
        'fields'       => 'object',
    ];
}
