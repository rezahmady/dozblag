<?php

namespace Modules\Unity\Models;

use App\Models\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Unity\Enums\TruckContractStatus;

class TruckContract extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'truck_contracts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'json',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getStatusBrowse() {

        $status = null;

        switch ($this->contract_status) {
            case TruckContractStatus::Active->value:
                $status = '<span class="badge badge-success center"><span class="circle"></span>'.trans('unity::unity.status.'.TruckContractStatus::Active->value).'</span>';
                break;
            case TruckContractStatus::Rejected->value:
                $status = '<span class="badge badge-danger center"><span class="circle"></span>'.trans('unity::unity.status.'.TruckContractStatus::Rejected->value).'</span>';
                break;
            case TruckContractStatus::Pending->value:
                $status = '<span class="badge badge-warning center"><span class="circle"></span>'.trans('unity::unity.status.'.TruckContractStatus::Pending->value).'</span>';
                break;
            case TruckContractStatus::Expired->value:
                $status = '<span class="badge badge-default center"><span class="circle"></span>'.trans('unity::unity.status.'.TruckContractStatus::Expired->value).'</span>';
                break;
        }
        echo $status;
        return ' ';
    }

    public function getLogo() {
        echo '<img width="50px" src="'.url($this->images[0] ?? '/modules/unity/img/noimage.png').'">';
        return ' ';
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

    public function user()
    {
        return $this->belongsTo(User::class);
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
