<?php

namespace Modules\User\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use App\Traits\SetJsonMutator;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Unity\Models\Unity;
use Spatie\Permission\Traits\HasRoles;
use Venturecraft\Revisionable\RevisionableTrait;


class User extends Authenticatable
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use HasFactory, Notifiable, HasRoles, CrudTrait,SetJsonMutator, RevisionableTrait;

    public static function boot()
    {
        parent::boot();
    }

    public function identifiableName()
    {
        return $this->name;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'password',
        'template',
        'extras',
    ];

    protected $fakeColumns = ['extras'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'extras'         => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent() {
        return $this->belongsTo(self::class);
    }

    public function relationBelongsTo()
    {
        return $this->belongsTo(self::class);
    }

    public function relationHasMany()
    {
        return $this->hasMany(self::class);
    }


    public function ostan()
    {
        return $this->belongsTo(Ostan::class, 'extras->ostan_id');
    }

    public function shahrestan()
    {
        return $this->belongsTo(Shahrestan::class, 'extras->shahrestan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function username()
    {
        return 'mobile';
    }

    public function getLoginAsButton($crud = false)
    {
        return '<a class="btn btn-sm btn-link" href="'.url('/admin/user/loginAsUser', $this->id).'" target="_blank">'.
            '<i class="la la-key"></i> ورود</a>';
        return '';
    }


    public function getProfile()
    {
        $image = 'assets/garrin/img/user.svg';
        $src = $this->extras->profile ?? $image;
        return asset($src);
    }

    public function routeNotificationForTelegram()
    {
        return $this->telegram_user_id;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
