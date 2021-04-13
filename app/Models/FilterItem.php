<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\ImageManagerStatic as Image;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilterItem extends Model
{
    use HasFactory;
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'filter_items';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'parent_id', 'filter_id', 'image'];
    // protected $hidden = [];
    // protected $dates = [];



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function path()
    {
        return '/';
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo('App\Models\FilterItem', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\FilterItem', 'parent_id');
    }

    public function filter()
    {
        return $this->belongsTo('App\Models\Filter', 'filter_id');
    }

    public function filterModule()
    {
        return $this->belongsTo('App\Models\Filter', 'filter_id')->where('module', 'User');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
                    ->orWhere('depth', null)
                    ->orderBy('lft', 'ASC');
    }

    public function scopeField($query, $id)
    {
        return $query->where('filter_id', $id);
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

    // public function setImageAttribute($value)
    // {
    //     $attribute_name = "image";
    //     // or use your own disk, defined in config/filesystems.php
    //     $disk = config('backpack.base.root_disk_name');
    //     // destination path relative to the disk above
    //     $destination_path = "public/uploads/images/filter";

    //     // if the image was erased
    //     if ($value==null) {
    //         // delete the image from disk
    //         Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name});

    //         // set null in the database column
    //         $this->attributes[$attribute_name] = null;
    //     }

    //     // if a base64 was sent, store it in the db
    //     if (Str::startsWith($value, 'data:image'))
    //     {
    //         // 0. Make the image
    //         $image = Image::make($value)->encode('jpg', 90);

    //         // 1. Generate a filename.
    //         $filename = md5($value.time()).'.jpg';

    //         // 2. Store the image on disk.
    //         Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

    //         // 3. Delete the previous image, if there was one.
    //         Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name});

    //         // 4. Save the public path to the database
    //         // but first, remove "public/" from the path, since we're pointing to it
    //         // from the root folder; that way, what gets saved in the db
    //         // is the public URL (everything that comes after the domain name)
    //         // $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
    //         $this->attributes[$attribute_name] = $filename;
    //     }
    // }
}
