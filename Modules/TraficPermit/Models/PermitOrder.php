<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Unity\Models\Driver;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\Unity;

class PermitOrder extends Model
{
    use CrudTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'permit_orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = ['extras'];
    // protected $hidden = [];
    // protected $dates = [];

    protected $with = ['unity', 'truck', 'driver', 'destination'];

    protected $fakeColumns = ['extras'];

    protected $casts = [
        'extras' => 'object',
        'photos' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

//    public function setPhotosAttribute($value)
//    {
//        $attribute_name = "photos";
//        $disk = "local";
//        $destination_path = "permit-order-attachments";
//
//        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
//    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 'pending':
                $status = '<span class="badge badge-warning center"><span class="circle"></span>درجریان</span>';
                break;
            case 'issuing':
                $status = '<span class="badge badge-info center"><span class="circle"></span>درحال صدور</span>';
                break;
            case 'completed':
                $status = '<span class="badge badge-success center"><span class="circle"></span>صادر شده</span>';
                break;

            default:
                # code...
                break;
        }
        echo $status;
        return ' ';
    }

    public function getDateBrowse()
    {
        return verta($this->created_at)->format('Y/m/d');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Trailer::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function traficPermits()
    {
        return $this->belongsToMany(TraficPermit::class)->withPivot('status', 'date');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'extras->countries');
    }

    public function destination()
    {
        return $this->belongsTo(Country::class, 'destination_id');
    }

    public function exports()
    {
        $instance = $this->hasMany(TraficPermitExport::class);
        $instance->getQuery()->where('status','=', 1);
        return $instance;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
