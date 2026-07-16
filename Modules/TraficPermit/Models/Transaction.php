<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Unity\Models\Unity;

class Transaction extends Model
{
    use CrudTrait;
    //protected $with = ['export'];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'transactions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = ['amount', 'unity_id'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $touches = ['unity'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getAmount()
    {
        return number_format($this->amount);
    }

    public function getType()
    {
        return trans('traficpermit::traficpermit.transaction_types.'.$this->type);
    }

    public function getDate()
    {
        return verta($this->date ?? $this->created_at)->format('Y/m/d');
    }

    public function getTruckName()
    {
        if($this->export) {
            return $this->export()->getTruck();
        } else {
            return '';
        }
    }

    public function getDriverName()
    {
        if($this->export) {
            return $this->export->order->driver->fa_name;
        } else {
            return '';
        }
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

    public function export()
    {
        return $this->belongsTo(TraficPermitExport::class);//, 'trafic_permit_export_id', 'id');
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
