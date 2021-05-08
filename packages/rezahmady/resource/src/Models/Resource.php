<?php

namespace Rezahmady\Resource\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use App\Models\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resource extends Model
{
    use HasFactory;
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'resources';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'caption', 'template', 'extras'];
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


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function ostan()
    {
        return $this->belongsTo(Ostan::class);
    }

    public function Shahrestan()
    {
        return $this->belongsTo(Shahrestan::class);
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
}
