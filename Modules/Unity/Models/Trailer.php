<?php

namespace Modules\Unity\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trailer extends Model
{
    use HasFactory, CrudTrait, SoftDeletes;

    protected $fillable = [
        'transit_number',
        'iranian_plates_number',
        'type',
        'model',
        'chassis_number',
        'truck_id',
        'unity_id',
        'engine_number',
        'vehicletype_id',
        'status',
    ];

    protected $with = ['truck'];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function vehicletype()
    {
        return $this->belongsTo(Vehicletype::class, 'vehicletype_id', 'id');
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 1:
                $status = '<span class="badge badge-success center"><span class="circle"></span>فعال</span>';
                break;
            case 0:
                $status = '<span class="badge badge-warning center"><span class="circle"></span>غیرفعال</span>';
                break;
        }
        echo $status;
        return ' ';
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }

}
