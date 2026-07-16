<?php

namespace Modules\Unity\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\TraficPermit\Models\PermitOrder;
use Modules\TraficPermit\Models\TraficPermit;
use Modules\TraficPermit\Models\TraficPermitExport;

class Truck extends Model
{
    use HasFactory, CrudTrait, SoftDeletes;

    protected $fillable = [
        'transit_number',
        'iranian_plates_number',
        'unity_id',
        'type',
        'model',
        'chassis_number',
        'engine_number',
        'status',
        'vehicletype_id',
        // 'trailer_id',
        'extras',
    ];

    protected $with = ['unity'];

    protected $fakeColumns = ['extras'];

    protected $casts = [
        'extras' => 'object'
    ];

    public function truckContracts()
    {
        return $this->hasMany(Unity::class);
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }

    public function vehicletype()
    {
        return $this->belongsTo(Vehicletype::class, 'vehicletype_id', 'id');
    }

    public function trailer()
    {
        return $this->hasOne(Trailer::class);
    }

    public function permit_order()
    {
        return $this->hasMany(PermitOrder::class);
    }


    public function traficpermits1()
    {
        return $this->hasManyDeep(
            TraficPermit::class, [PermitOrder::class, TraficPermitExport::class]);
    }

    public function traficpermits()
    {
        return $this->hasMany(PermitOrder::class)
        ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
        ->join('trafic_permits', 'trafic_permits.id', '=', 'permit_order_trafic_permit.trafic_permit_id')
        ;// ->where('trafic_permits.status', 'issued');
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

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
