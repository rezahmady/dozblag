<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class TraficPermitTemplate extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'trafic_permit_templates';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $fakeColumns = ['extras'];

    protected $casts = [
        'extras' => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 1:
                $status = '<span class="badge badge-success right">فعال</span>';
                break;
            case 0:
                $status = '<span class="badge badge-danger right">غیرفعال</span>';
                break;

            default:
                # code...
                break;
        }
        echo $status;
        return ' ';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function types()
    {
        return $this->morphToMany(TraficPermitType::class, 'trafic_permit_typeable');
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class);
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
