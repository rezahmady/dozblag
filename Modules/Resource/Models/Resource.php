<?php

namespace Modules\Resource\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use App\Models\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Rezahmady\SettingOperation\Setting;

class Resource extends Model
{
    use HasFactory;
    use CrudTrait,Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'resources';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'caption', 'status', 'template', 'slug', 'extras',
        'extras->bio', 'extras->address', 'extras->profile'
    ];
    protected $fakeColumns = ['extras'];
    const LIMIT = 35;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extras'         => 'object',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() :array
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }


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

    public function getNameWithCaption() {
        echo '<span>'.$this->limitName.'</span><br><span>'.$this->limitCaption.'</span>';
    }

    public function getTemplateName()
    {
        return trans('backpack::permissionmanager.function_name.'.$this->template);
    }

    public function getProfile()
    {
        $src = $this->extras->profile ?? Setting::get("resources.template_{$this->template}_default_img") ?? '';
        return asset($src);
    }

    public function getShahrestan()
    {
        return $this->extras->shahrestan->name ?? $this->shahrestan->name ??'';
    }

    public function path()
    {
        return route('resource.show',$this->slug);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function ostan()
    {
        return $this->belongsTo(Ostan::class, 'ostan_id');
    }

    public function shahrestan()
    {
        return $this->belongsTo(Shahrestan::class, 'shahrestan_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getLimitNameAttribute()
    {
        return Str::limit($this->name, self::LIMIT );
    }

    public function getLimitCaptionAttribute()
    {
        return Str::limit($this->caption, self::LIMIT );
    }

    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
