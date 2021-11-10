<?php

namespace Modules\Payment\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discount extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'discounts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name','caption','type','value','start_date', 'end_date', 'capacity', 'limit'];
    const LIMIT = 35;
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
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

    public function getTypeBrowse() {

        $status = null;

        switch ($this->type) {
            case 'PERCENT':
                $status = '%';
                break;
            case 'EQUAL':
                $status = 'تومان';
                break;

            default:
                # code...
                break;
        }
        echo $status;
    }

    public function getNameWithCaptionBrowse()
    {
        echo '<b>'.$this->name.'</b><br><span>'.$this->limitCaption.'</span><br>';
    }

    public function getValueBrowse()
    {
        if($this->type == 'PERCENT') {
            $value = $this->value;
            $limit = "<br><small>تا سقف {$this->getLimitBrowse()}</small>";
        } else {
            $value = number_format($this->value);
            $limit = '';
        }

        echo $value.$this->getTypeBrowse().$limit;
    }

    public function getLimitBrowse()
    {
        return number_format($this->limit);
    }

    public function applayDiscount($amount)
    {
        switch ($this->type) {
            case 'PERCENT':
                $value = ((int)$amount * (int)$this->value)/100;
                if($this->limit) {
                    $amount_after_discount = ( $value < (int)$this->limit ) ? (int)$amount-$value : (int)$amount - (int)$this->limit;
                } else {
                    $amount_after_discount = (int)$amount - $value ;
                }
                return (int)$amount_after_discount;
                break;
            case 'EQUAL':
                return  ((int)$amount - (int)$this->value > 0 ) ? (int)$amount - (int)$this->value : 0;
                break;

            default:
                # code...
                break;
        }
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

    public function getLimitCaptionAttribute()
    {
        return Str::limit($this->caption, self::LIMIT );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
