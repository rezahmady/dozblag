<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\TraficPermit\Models\PermitOrder;
use Modules\TraficPermit\Models\TraficPermit;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TraficPermitExport extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'permit_order_trafic_permit';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['order'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getOrderRelationAttributes($relation, $attribute)
    {
        return $this->order->{$relation}->{$attribute};
    }

    public function getCountry() {
        return $this->traficpermit->repository->country->fa_name;
    }

    public function getAmount()
    {
        return number_format($this->amount);
    }

    public function getTruck()
    {
        // return $this->order->trailer->transit_number;
        return '<span style="
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;"><span class="mb-1">'.$this->order->truck->transit_number.'</span>'.$this->order->trailer->transit_number.'</span>';
    }

    /**
     * Return only the truck's transit number (used by exports).
     */
    public function getTruckOnly()
    {
        return optional(optional($this->order)->truck)->transit_number ?? '-';
    }

    /**
     * Return only the trailer's transit number (used by exports).
     */
    public function getTrailerOnly()
    {
        return optional(optional($this->order)->trailer)->transit_number ?? '-';
    }

    /**
     * Return the permit's year, sourced from the related traficpermit -> repository.
     *
     * This was previously referenced by the controller via getYear() but the
     * method did not exist on this model, causing a BadMethodCallException.
     */
    public function getYear()
    {
        $repository = optional(optional($this->traficpermit)->repository);
        if (!$repository || !$repository->year) {
            return '-';
        }
        try {
            return date('Y', strtotime($repository->year));
        } catch (\Throwable $e) {
            return '-';
        }
    }

    public function getTraficpermitRelationAttributes($relation, $attribute)
    {
        return $this->traficpermit->{$relation}->{$attribute};
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function traficpermit()
    {
        return $this->belongsTo(TraficPermit::class, 'trafic_permit_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(PermitOrder::class, 'permit_order_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Get the repository's full name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function exportDate(): Attribute
    {

        $date = verta($this->date)->format('Y/m/d');
        return Attribute::make(
            get: fn () => $date
        );
    }

    public function receivedDate(): string
    {
        if (empty($this->get_carcasses_at)) {
            return '';
        }

        return verta($this->get_carcasses_at)->format('Y/m/d');
    }

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
