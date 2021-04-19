<?php

namespace Rezahmady\User\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use HasFactory, Notifiable, HasRoles, CrudTrait;

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
        'extras'
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

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

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
