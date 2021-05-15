<?php

namespace Rezahmady\Subscribtion\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Rezahmady\Payment\Models\Invoice;
use Rezahmady\Payment\Traits\HasPayment;
use Alert;

class Subscribtion extends Model
{
    use CrudTrait, HasPayment;

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

    public function runAfterSettled(Invoice $invoice)
    {
        backpack_user()->subscribtions()->save($this, [
            'expire_date' => Carbon::now()->addDay($this->extras->limit_duration)->format('Y-m-d H:i:s'),
            'capacity'    => $this->extras->limit_capacity
        ]);
    }

    public function callbackPayment($status, $message)
    {
        if($status == 'OK') {
            Alert::success($message)->flash();
        } else {
            Alert::error($message)->flash();
        }

        return redirect()->to('/');
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

    public function scopeActive($query)
    {
        return $query->where('extras->status', 1);
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
