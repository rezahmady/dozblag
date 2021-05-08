<?php

namespace Rezahmady\User\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use App\Traits\SetJsonMutator;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Rezahmady\Resource\Models\Resource;

class User extends Authenticatable
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use HasFactory, Notifiable, HasRoles, CrudTrait,SetJsonMutator;

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
        'extras->sex',
        'extras->bio',
        'extras->edu_bg',
        'extras->job_bg',
        'extras->gif_bg',
        'extras->ostan',
        'extras->shahrestan',
        'extras->address',
        'extras->profile',
        'extras->services',
        'extras->experience',
        'extras->medical_code',
        'extras->specialty_id',
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

    public function resource()
    {
        return $this->belongsToMany(Resource::class);
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

    public function path()
    {
        return url('/');
    }

    public function getPageLink()
    {
        return url('doctor/'.$this->id);
    }

    public function getOpenButton()
    {
        if($this->template === 'doctor') {
            return '<a class="btn btn-sm btn-link" href="'.$this->getPageLink().'" target="_blank">'.
                '<i class="la la-eye"></i> نمایش</a>';
        }
        return '';
    }

    public function hasTemplate($template)
    {
        if(is_array($template)) {
            return in_array($this->template, $template);
        }
        return $this->template == $template;//or $this->hasRole(trans("rezahmady.user::permissionmanager.function_name.{$template}")
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getProfileAttribute()
    {
        $src = $this->extras->profile ?? 'assets/garrin/img/user.svg';
        return asset($src);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setExtrasAttribute($values)
    {
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = "public/uploads/images/user/";

        foreach($values as $attribute => $value)
        {
            if (Str::startsWith($value, 'data:image')){

                // 0. Make the image
                $image = Image::make($value)->encode('jpg', 90);

                // 1. Generate a filename.
                $filename = md5($value.time()).'.jpg';

                // 2. Store the image on disk.
                Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                // 3. Delete the previous image, if there was one.
                if(isset($this->extras->$attribute)) Storage::disk($disk)->delete('/public/'.$this->extras->$attribute);

                // 4. Save the public path to the database
                // but first, remove "public/" from the path, since we're pointing to it
                // from the root folder; that way, what gets saved in the db
                // is the public URL (everything that comes after the domain name)
                $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
                $values[$attribute] = $public_destination_path.$filename;
            }
            elseif ($value == null) {
                // delete the image from disk
                Storage::disk($disk)->delete($this->{$attribute});
            }
        }

        $this->attributes['extras'] = json_encode($values);
    }
}
