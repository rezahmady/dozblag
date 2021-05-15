<?php

namespace Rezahmady\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Intervention\Image\ImageManagerStatic as Image;
use Venturecraft\Revisionable\RevisionableTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Rezahmady\Filter\Models\FilterItem;
use Rezahmady\Page\Models\Page;
use Rezahmady\Payment\Models\Invoice;

class Product extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use HasFactory;
    use CrudTrait;
    use RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;
    const LIMIT = 35;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'caption', 'content', 'status', 'metas', 'slug', 'gallery', 'template', 'settings', 'description', 'parameters', 'extras', 'filters', 'image'];
    // protected $hidden = [];
    // protected $dates = [];
    // public $translatable = ['name', 'caption', 'content', 'metas', 'settings', 'description', 'parameters', 'type_data'];
    protected $fakeColumns = ['filters', 'settings', 'metas', 'extras'];
    public $casts = [
        'features'       => 'object',
        'metas'          => 'object',
        'gallery'        => 'object',
        'content'        => 'string',
        'parameters'     => 'object',
        'extras'         => 'object',
        'settings'       => 'object',
        'filters'        => 'object',
    ];

    // protected $revisionEnabled = true;
    // protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    // protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    // protected $revisionForceDeleteEnabled = true;
    // protected $revisionCreationsEnabled = true;
    // protected $keepRevisionOf = ['title'];
    // protected $dontKeepRevisionOf = ['category_id'];
    // 'additional_fields' => ['account_id', 'permissions_id', 'other_id'], 
    public function identifiableName()
    {
        return $this->name;
    }

    // If you are using another bootable trait
    // be sure to override the boot method in your model
    // public static function boot()
    // {
    //     parent::boot();
    // }


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

    public function getImageThumb() {
        $image = ($this->image) ? url($this->image) : url('images/product_noimage.png');
        echo '<div class=""><img class="img-radius-5 " width="50px" height="50px" src="'.$image.'" alt="img"><span class="avatar-status badge-danger"></span></div>';
    }

    public function getNameWithCaption() {
        echo '<span>'.$this->limitName.'</span><br><span>'.$this->limitCaption.'</span>';
    }


    public function path()
    {
        return route('product.show',['product' => $this->slug]);
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 'PUBLISHED':
                $status = '<span class="badge badge-success center">انتشار</span>';
                break;
            case 'PENDING':
                $status = '<span class="badge badge-warning center">بررسی</span>';
                break;
            case 'DRAFT':
                $status = '<span class="badge badge-danger center">غیرفعال</span>';
                break;
            
            default:
                # code...
                break;
        }
        echo $status;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function filter()
    {
        return $this->belongsTo(FilterItem::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class)->with('childrenRecursive');
    }

    public function invoices()
    {
        return $this->morphToMany(Invoice::class, 'invoiceable');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        // return $this->settings->get('status') == 'PUBLISHED';
        return $query->where('settings->status',  'PUBLISHED');
    }

    public function scopeSearch($query , $keyword)
    {
        $query->where('title', 'LIKE', '%' . $keyword . '%')
            ->orWhere('caption', 'LIKE', '%' . $keyword . '%');
        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

    public function getSettingsAttribute($value)
    {
        return collect(json_decode($value));
    }

    public function getExtrasAttribute($value)
    {
        return collect(json_decode($value));
    }

    // public function getPagesAttribute($value)
    // {
    //     return json_decode($this->extras->get('pages'));
    // }

    public function getStatusAttribute()
    {
        return $this->settings->get('status');
    }

    public function getLimitNameAttribute()
    {
        return Str::limit($this->name, self::LIMIT );
    }

    public function getLimitCaptionAttribute()
    {
        return Str::limit($this->caption, self::LIMIT );
    }

    public function getDateAttribute()
    {
        return $this->created_at;
    }

    public function getThumbAttribute()
    {
        return ($this->image) ? url($this->image) : url('images/product_noimage.png');
    }



    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name'); 
        // destination path relative to the disk above
        $destination_path = "public/uploads/images/product"; 

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            // Storage::disk($disk)->delete('/public/'.$this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            if(isset($this->{$attribute_name})) Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it 
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }

}
