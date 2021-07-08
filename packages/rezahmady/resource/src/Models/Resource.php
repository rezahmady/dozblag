<?php

namespace Rezahmady\Resource\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use App\Models\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    protected $fillable = ['name', 'caption', 'template', 'slug', 'extras'];
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

    public function getNameWithCaption() {
        echo '<span>'.$this->limitName.'</span><br><span>'.$this->limitCaption.'</span>';
    }

    public function getTemplateName()
    {
        return trans('backpack::permissionmanager.function_name.'.$this->template);
    }

    public function getProfile()
    {
        if($this->extras->profile) {
            
        }
        $src = $this->extras->profile ?? "uploads/images/themes/garrin/{$this->template}.jpg";
        return asset($src);
    }

    public function getShahrestan()
    {
        return $this->extras->shahrestan->name ?? '';
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
        return $this->belongsTo(Ostan::class, 'extras->ostan');
    }

    public function shahrestan()
    {
        return $this->belongsTo(Shahrestan::class, 'extras->shahrestan_id');
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
}
