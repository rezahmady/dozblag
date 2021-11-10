<?php

namespace Modules\Payment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'invoices';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'amount','discount_id','tax_typ', 'tax'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getUserBrowse()
    {
        $url = backpack_url('user/'.$this->user->id.'/edit');
        echo "<a href='{$url}' >{$this->user->name}</a>";
    }

    public function getAmountBrowse()
    {
        echo number_format($this->amount);
    }

    public function getStatusBrowse() {
        $status = '<span class="badge badge-danger center">عدم پرداخت</span>';
        $settled = $this->transactions()->settled()->first();
        if($settled) {
            $status = '<span class="badge badge-success center">پرداخت شده</span>';
        }
        echo $status;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function invoiceable()
    {
        return $this->morphTo();
    }


    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getDateBrowse()
    {
        $date = $this->updated_at;
        $v = Verta($date);
        echo $v->format('Y/n/j');
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeSettled($query)
    {
        return $query->whereHas('transactions', function($q){
            $q->settled();
        });
    }

    public function scopeNotsettled($query)
    {
        return $query->whereDoesntHave('transactions', function($q){
            $q->settled();
        });
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
