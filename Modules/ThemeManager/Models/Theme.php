<?php

namespace Modules\ThemeManager\Models;

use App\Traits\HasTranslations;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Hekmatinasser\Verta\Verta;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Theme extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $table = 'themes';
    protected $fillable = ['name', 'folder', 'version', 'img', 'extras', 'extras_translatable'];
    protected $fakeColumns = ['extras', 'extras_translatable'];
    protected $translatable = ['extras_translatable'];
    protected $casts = [
        'extras' => 'array',
    ];


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        // return $this->settings->get('status') == 'PUBLISHED';
        return $query->where('active',  1);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function widgets()
    {
        return $this->hasMany('App\Models\Widget');
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getUpdatedAtAttribute()
    {
        $v = new Verta($this->attributes['updated_at']);
        return $v->format('Y/n/j و ساعت H:i');
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
        $destination_path = "public/uploads/images/themes/".$this->folder;

        foreach($values as $attribute => $value)
        {
            if (Str::startsWith($value, 'data:image')){

                    // 0. Make the image
                $image = Image::make($value)->encode('png', 100);

                // 1. Generate a filename.
                $filename = md5($value.time()).'.png';

                // 2. Store the image on disk.
                Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                // 3. Delete the previous image, if there was one.
                if(isset($this->extras[$attribute])) Storage::disk($disk)->delete('/public/'.$this->extras[$attribute]);

                // 4. Save the public path to the database
                // but first, remove "public/" from the path, since we're pointing to it 
                // from the root folder; that way, what gets saved in the db
                // is the public URL (everything that comes after the domain name)
                $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
                $values[$attribute] = $public_destination_path.'/'.$filename;
            }
            elseif ($value == null and $this->{$attribute} != null) {
                // delete the image from disk
                if(Storage::disk($disk)->exists($this->{$attribute})) {
                    Storage::disk($disk)->delete($this->{$attribute});
                }
            }
        }

        $this->attributes['extras'] = json_encode($values);
    }
}
