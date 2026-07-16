<?php

namespace Modules\Unity\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Modules\TraficPermit\Enums\TransactionType;
use Modules\TraficPermit\Models\PermitOrder;
use Modules\TraficPermit\Models\Transaction;
use Modules\Unity\Enums\UnityStatus;

class Unity extends Model
{
    use HasFactory, CrudTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fa_name',
        'en_name',
        'national_id',
        'registration_number',
        'registration_date',
        'shahrestan_id',
        'ostan_id',
        'tell',
        'zip_code',
        'image',
        'fa_address',
        'en_address',
        'description',
        'status',
        'extras',
    ];

    protected $fakeColumns = ['extras'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extras' => 'object',
        'image' => 'json',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function users()
    {
        return $this->hasMany(\Modules\User\Models\User::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function orders()
    {
        return $this->hasMany(PermitOrder::class);
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function cacheKey()
    {
        return sprintf(
            "%s/%s-%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }

    /**
     * Get the string of repository's types id.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function cashedBalance(): Attribute
    {
        return Attribute::make(
            get: function ()  {
                return Cache::remember($this->cacheKey() . ':wallet_balance', 60*60*24*365, function () {
                    return (int) $this->transaction()->where('type', TransactionType::Deposit)->sum('amount') - $this->transaction()->where('type', TransactionType::Withdraw)->sum('amount');
                });
            }
        );
    }

    /**
     * Get the string of repository's types id.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function cashedBalanceColumn(): Attribute
    {
        return Attribute::make(
            get: function ()  {
                $color = ($this->cashed_balance < 0) ? 'red' : 'green';
                return '<span dir="ltr" style="color: '.$color.'">'.number_format($this->cashed_balance).'</span>';
            }
        );
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case UnityStatus::Active->value:
                $status = '<span class="badge badge-success center"><span class="circle"></span>'.trans('unity::unity.status.'.UnityStatus::Active->value).'</span>';
                break;
            case UnityStatus::Inactive->value:
                $status = '<span class="badge badge-danger center"><span class="circle"></span>'.trans('unity::unity.status.'.UnityStatus::Inactive->value).'</span>';
                break;
        }
        echo $status;
        return ' ';
    }

    public function getLogo() {
        echo '<img width="50px" src="'.url($this->image[0] ?? '/modules/unity/img/noimage.png').'">';
        return ' ';
    }

    public function ostan()
    {
        return $this->belongsTo(Ostan::class);
    }

    public function shahrestan()
    {
        return $this->belongsTo(Shahrestan::class);
    }
}
