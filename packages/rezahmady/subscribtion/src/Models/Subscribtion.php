<?php

namespace Rezahmady\Subscribtion\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Subscribtion extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subscribtions';
    protected $fillable = ['name', 'description', 'amount', 'extras'];
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

    public function getAmount()
    {
        return number_format($this->amount);
    }
    
    public function getStatusBrowse() {

        $status = null;

        switch ($this->extras->status) {
            case 1:
                $status = '<span class="badge badge-success center">منتشر شده</span>';
                break;
            case 0:
                $status = '<span class="badge badge-danger center">عدم انتشار</span>';
                break;
            
            default:
                # code...
                break;
        }
        echo $status;
    }


    public function getPaymentPath()
    {

    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
