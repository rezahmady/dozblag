<?php

namespace Modules\TraficPermit\Models;

use App\Support\Export\ExportContext;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Models\TraficPermitExport;
use Modules\TraficPermit\Models\TraficPermitType;

class TraficPermit extends Model
{
    use CrudTrait, SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'trafic_permits';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['repository', 'exports', 'types'];
    protected $appends = ['full_name', 'serial', 'types_string'];

    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * When running inside an export, skip auto-appending heavy HTML accessors
     * so JSON-serialization and array casting stay cheap. Normal requests are
     * unaffected.
     */
    public function getArrayableAppends()
    {
        if (ExportContext::isActive()) {
            return [];
        }
        return parent::getArrayableAppends();
    }

    /**
     * Return the latest active export for this permit.
     *
     * During an export, use the preloaded map (filled by
     * exportPreloadCallback) instead of hitting the DB per row.
     */
    protected function latestActiveExport()
    {
        if (ExportContext::isActive()
            && ExportContext::has('latest_export_per_permit')) {
            return ExportContext::get('latest_export_per_permit', $this->id);
        }
        return $this->exports()->latest()->where('status', 1)->first();
    }

    public function getCountry()
    {
        return $this->repository->full_name;
    }

    public function getYear()
    {
        return $this->repository->getYear();
    }

    public function serialNumber()
    {
        return $this->country->prefix.$this->serial_number;
    }

    protected function serial(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->country->prefix.$this->serial_number,
        );
    }

    public function exportDate()
    {
        $export = $this->latestActiveExport();
        $date = $export->date ?? false;
        return ($date) ? verta($date)->format('Y/m/d') : '-';
    }

    public function getCarcassDelivery()
    {
        return ($this->status == TraficPermitStatus::Consumed->value) ? verta($this->updated_at)->format('Y/m/d') : '-';
    }

    public function deadlineToComBack()
    {
        if($this->status == TraficPermitStatus::Issued->value) {
            $export = $this->latestActiveExport();
            $date = $export->date ?? false;
            if($date) {
                $counter = 60 - verta($date)->diffDays();
                if($counter < 0) {
                    echo '<span class="badge badge-danger center" style="color:red"><span class="circle"></span>'.abs($counter).' روز از تحویل گذشته</span>';
                    return ' ';
                } elseif($counter < 30) {
                    echo '<span class="badge badge-warning center"><span class="circle"></span>'.$counter.' روز مانده</span>';
                    return ' ';
                } elseif($counter < 60) {
                    echo '<span class="badge badge-success center"><span class="circle"></span>'.$counter.' روز مانده</span>';
                    return ' ';
                }
            } else {
                return '-';
            }
        }
        echo '<span class="badge badge-success center"><span class="circle"></span>تحویل شده</span>';
        return ' ';
    }

    public function exportUnity()
    {
        $export = $this->latestActiveExport();
        return ($export) ? $export->order->unity->fa_name : '-';
    }

    public function getExportCount()
    {
        return '<a href="'.backpack_url('/trafic-permit-export?traficpermit='.$this->id).'"><button class="btn btn-default d-flex" style="font-size: 12px;
        gap: 5px;
        align-items: center;" type="link">مشاهده<span class="badge badge-light" style="position: static;font-size: 10px;">'.$this->exports->count().'</span></button></a>';
    }

    public function carcassDelivery() {
        $this->update([
            'status' => TraficPermitStatus::Consumed
        ]);

        return $this;
    }

    public function changeStatus(TraficPermitStatus $status) {
        $this->update([
            'status' => $status
        ]);

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }

    public function country()
    {
        return $this->repository->country();
    }

    public function types()
    {
        return $this->morphToMany(TraficPermitType::class, 'trafic_permit_typeable');
    }

    public function exports()
    {
        $instance = $this->hasMany(TraficPermitExport::class);
        $instance->getQuery()->where('status','=', 1);
        return $instance;
    }

    /**
     * All export rows including drafts (status = 0).
     * Use this for print/report so updateOrCreate can find drafts.
     */
    public function allExports()
    {
        return $this->hasMany(TraficPermitExport::class);
    }

    public function orders()
    {
        return $this->belongsToMany(PermitOrder::class);
    }

    public function getTruck()
    {
        $export = $this->latestActiveExport();

        return ($export) ? '<span style="
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;"><span class="mb-1">'.$export->order->truck->transit_number.'</span>'.$export->order->trailer->transit_number.'</span>' : '-';
    }

    public function getTruckOnly() {
        $export = $this->latestActiveExport();
        return ($export) ? $export->order->truck->transit_number : '-';
    }

    public function getTrailerOnly() {
        $export = $this->latestActiveExport();
        return ($export) ? $export->order->trailer->transit_number : '-';
    }

    public function getTraficpermitRelationAttributes($relation, $attribute)
    {
        return $this->{$relation}->{$attribute};
    }

    public function getOrderRelationAttributes($relation, $attribute)
    {
        $export = $this->latestActiveExport();

        return ($export) ? $export->order->{$relation}->{$attribute} : null;
    }

    public function getOrderAttributes($attribute, $type = 'text')
    {
        $export = $this->latestActiveExport();

        return
        ($export) ?
            (($type == 'date')
            ? verta($export->order->{$attribute})->format('Y/m/d')
            : $export->order->{$attribute})
        : null;
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

    /**
     * Get the traficpermit's full name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => '<div class="d-flex flex-column"><span class="mb-2" style="background: #4d565e;
            color: white;
            padding: 5px 5px;
            border-radius: 3px;"><i class="la la-flag mr-1"></i>'.$this->repository->country->fa_name.'</span><span class="mb-2" style=""><i class="la la-qrcode mr-1"></i>'.$this->serial_number.'</span><small class="d-block" style=""><i class="la la-folder mr-1"></i>'.$this->typesString.'</small></div>'//." <br><br> <i class='la la-box'></i> <small> ".$this->start_serial_number." تا ".$this->end_serial_number."</small>",
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
                $types =  $this->types->pluck('title')->toArray();
                sort($types);
                return implode(' | ', $types );
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
