<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\ImageManagerStatic as Image;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Widget extends Model
{
    use HasFactory;
    use CrudTrait;
    use HasTranslations;

    protected $table = 'widgets';
    protected $fillable = ['name', 'prefix', 'label', 'type', 'cat', 'description', 'theme_id', 'status', 'extras', 'extras_translatable'];
    protected $fakeColumns = ['extras', 'extras_translatable'];
    protected $translatable = ['extras_translatable'];

    protected $casts = [
        'extras' => 'array',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function theme()
    {
        return $this->belongsTo('App\Models\Theme');
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
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setExtrasAttribute($values)
    {
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = "public/uploads/images/page/";

        if(is_array($values)) foreach($values as $attribute => $value)
        {
            if (!is_array($value) and  Str::startsWith($value, 'data:image')){

                    // 0. Make the image
                $image = Image::make($value)->encode('png', 90);

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
                $values[$attribute] = $public_destination_path.$filename;
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
