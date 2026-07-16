<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\TraficPermit\Models\TraficPermitType;

class Country extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'countries';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['amount', 'prefix', 'status', 'can_duplicate', 'image', 'fa_name', 'en_name'];
    // protected $hidden = [];
    // protected $dates = [];

    protected $identifiableAttribute = 'fa_name';

    protected $casts = [
        'image' => 'json',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function fullname()
    {
        return $this->fa_name."<br><br>".$this->en_name;
    }

    public function getAmountBrows()
    {
        return number_format($this->amount);
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 1:
                $status = '<span class="badge badge-success center"><span class="circle"></span>فعال</span>';
                break;
            case 0:
                $status = '<span class="badge badge-danger center"><span class="circle"></span>غیرفعال</span>';
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

    public function repositories()
    {
        return $this->hasMany(Repository::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

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
