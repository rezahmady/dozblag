<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Article;

class Page extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pages';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['template', 'name', 'title', 'slug', 'content', 'extras'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $fakeColumns = ['extras'];
    protected $casts = [
        'extras' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() :array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getTemplateName()
    {
        return trans('backpack::pagemanager.function_name.'.$this->template);
    }

    public function getPageLink()
    {
        return url($this->slug);
    }

    public function getOpenButton()
    {
        return '<a class="btn btn-sm btn-link" href="'.$this->getPageLink().'" target="_blank">'.
            '<i class="la la-eye"></i> '.trans('backpack::pagemanager.open').'</a>';
    }

    public function path()
    {
        return url($this->slug);
    }

    public function getPathAttribute()
    {
        return $this->path();
    }


    public function itemInChildren()
    {
        if (!$this->items($this->template)) return null;
        $allItem = [];
        $items = $this->items($this->template)->get();
        foreach($items as $item)
        {
            $allItem[$item->id] = $item;
        }

        foreach($this->childrenRecursive as $child) {
            $allItem  = $allItem + $child->itemInChildren();
        }
        return $allItem;
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo('App\Models\Page', 'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function getAllParentsId() {
        
        if(!$this->parent) return [$this->id];

        return array_merge([$this->id], $this->parent->getAllParentsId());
        
    }

    public function items($template = '')
    {

        switch ($this->template) {
            case 'shop':
                return $this->belongsToMany(Product::class);
                break;
                
            case 'blog':
                return $this->belongsToMany(Article::class);
                break;
            
            default:
                # code...
                break;
        }

    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeShopTemplate($query)
    {
        return $query->where('template',  'shop');
    }

    public function scopeBlogTemplate($query)
    {
        return $query->where('template',  'blog');
    }

    public function scopeFormTemplate($query)
    {
        return $query->where('template',  'form');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
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
                if(isset($this->extras[$attribute])) Storage::disk($disk)->delete('/public/'.$this->extras[$attribute]);

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
