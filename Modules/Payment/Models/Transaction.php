<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;
use Hekmatinasser\Verta\Facades\Verta;

class Transaction extends Model
{
    use CrudTrait, HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['invoice_id', 'driver', 'amount', 'transactionId', 'status', 'date','referenceId'];
    protected $dates = ['date'];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getUser()
    {
        return $this->invoice->user;
    }

    public function getAmountBrowse()
    {
        echo number_format($this->amount/10);
    }

    public function getUserBrowse()
    {
        $url = backpack_url('user/'.$this->invoice->user->id.'/edit');
        echo "<a href='{$url}' >{$this->invoice->user->name}</a>";
    }

    public function getDateBrowse()
    {
        $date = $this->date ?? $this->updated_at;
        $v = Verta($date);
        echo $v->format('Y/n/j H:i:s');
    }

    public function getDriveBrowse()
    {
        echo trans("payment::payment.drivers.{$this->driver}");
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 1:
                $status = '<span class="badge badge-success center">پرداخت شده</span>';
                break;
            case 0:
                $status = '<span class="badge badge-danger center">عدم پرداخت</span>';
                break;

            default:
                # code...
                break;
        }
        echo $status;
    }

    public function getTransactionIdBrowse()
    {
        echo (int)$this->transactionId;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeSettled($query)
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
