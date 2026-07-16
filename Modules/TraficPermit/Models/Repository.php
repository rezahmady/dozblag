<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\PermitOrderStatus;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Models\TraficPermitTemplate;
use Modules\TraficPermit\Models\TraficPermitType;
use Venturecraft\Revisionable\RevisionableTrait;

class Repository extends Model
{
    use CrudTrait, SoftDeletes, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'repositories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'unique_key'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['country'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getYear()
    {
        return date_format(new Carbon($this->year), 'Y');
    }

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

    public function identifiableName()
    {
        return $this->start_serial_number;
    }

    // If you are using another bootable trait
    // be sure to override the boot method in your model
    public static function boot()
    {
        parent::boot();

        static::deleting(function($repository) {
            $repository->traficpermits()->delete();
        });

        static::restoring(function ($repository) {
            // $repository->staff()->restore();
            TraficPermit::withTrashed()->where('repository_id',$repository->id)->restore();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function traficpermits()
    {
        return $this->hasMany(TraficPermit::class);
    }

    public function availableTraficpermits() {
        $instance = $this->hasMany(TraficPermit::class);
        $instance->getQuery()->whereIn('status', [TraficPermitStatus::Active, TraficPermitStatus::Inactive]);
        return $instance;
    }

    public function availableTraficpermitsForRequest() {
        $instance = $this->hasMany(TraficPermit::class);
        $instance->getQuery()->where('status', TraficPermitStatus::Active)
        ->whereDoesntHave('orders', function($q) {
            $q->whereIn('permit_orders.status', [PermitOrderStatus::Pending, PermitOrderStatus::Issuing]);
        });
        return $instance;
    }

    public function issuedTraficpermits() {
        $instance = $this->hasMany(TraficPermit::class);
        $instance->getQuery()->where('status', TraficPermitStatus::Issued);
        return $instance;
    }

    public function consumedTraficpermits() {
        $instance = $this->hasMany(TraficPermit::class);
        $instance->getQuery()->where('status', TraficPermitStatus::Consumed);
        return $instance;
    }

    public function revokeTraficpermits() {
        $instance = $this->hasMany(TraficPermit::class);
        $instance->getQuery()->whereIn('status', [TraficPermitStatus::Expired , TraficPermitStatus::Lost, TraficPermitStatus::Deformation]);
        return $instance;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function activeCountries()
    {
        return $this->belongsTo(Country::class)->active();
    }

    public function types()
    {
        return $this->morphToMany(TraficPermitType::class, 'trafic_permit_typeable');
    }

    public function traficPermitTemplate() {
        return $this->belongsTo(TraficPermitTemplate::class, 'trafic_permit_template_id', 'id');
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

    /**
     * Get the repository's full name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->country->fa_name//." <br><br> <i class='la la-box'></i> <small> ".$this->start_serial_number." تا ".$this->end_serial_number."</small>",
        );
    }

    /**
     * Get the string of repository's types id.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function typesString(): Attribute
    {
        return Attribute::make(
            get: function ()  {
                $types =  $this->types->pluck('id')->toArray();
                sort($types);
                return implode('-', $types );
            }
        );
    }

    /**
     * Get the string of repository's types id.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function typesLabel(): Attribute
    {
        return Attribute::make(
            get: function ()  {
                $types =  $this->types->pluck('title')->toArray();
                sort($types);
                return implode(' - ', $types );
            }
        );
    }

        /**
     * Get the array of repository's types id.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function typesArray(): Attribute
    {
        return Attribute::make(
            get: fn () =>  $this->types->pluck('id')->toArray()
        );
    }

    protected function uniqueKey(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->country_id.':'.$this->types_string

        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
