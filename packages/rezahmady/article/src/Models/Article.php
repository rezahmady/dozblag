<?php

namespace Rezahmady\Article\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Rezahmady\Comment\Models\Comment;
use Rezahmady\Page\Models\Page;
use App\Traits\ModelCommonMethods;
use Rezahmady\SettingOperation\Setting;

class Article extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers, ModelCommonMethods;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['slug', 'title', 'caption', 'content', 'image', 'status', 'featured','user_id', 'extras', 'like', 'dislike', 'whatsapp', 'telegram'];
    protected $fakeColumns = ['extras'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
        'extras'    => 'object',
        'like'      => 'integer',
        'dislike'      => 'integer',
        'telegram'      => 'integer',
        'whatsapp'      => 'integer',
    ];

    public function path()
    {
        return route('article', ['article' => $this->slug]);
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
                'source' => 'slug_or_caption_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 'PUBLISHED':
                $status = '<span class="badge badge-success center">منتشر شده</span>';
                break;
            case 'DRAFT':
                $status = '<span class="badge badge-danger center">عدم انتشار</span>';
                break;
            
            default:
                # code...
                break;
        }
        echo $status;
    }

    public function getPageLink()
    {
        return url('mag/'.$this->slug);
    }

    public function getOpenButton()
    {
        $status = ($this->status == 'PUBLISHED') ? 'نمایش' : 'پیش نمایش';
        return '<a class="btn btn-sm btn-link" href="'.$this->getPageLink().'" target="_blank">'.
            '<i class="la la-eye"></i> '.$status.'</a>';
    }

    public function getImage()
    {
        return $this->image ?? Setting::get('articles.default_image');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo('Rezahmady\User\Models\User', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Rezahmady\Article\Models\Tag', 'article_tag');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class)->with('parentRecursive');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id')->with('childrenRecursive')->where('parent_id', null);
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class, 'module_id')->with('childrenRecursive');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
                    // ->where('date', '<=', date('Y-m-d'))
                    // ->orderBy('date', 'DESC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrCaptionOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        if ($this->caption != '') {
            return $this->caption;
        }

        return $this->title;
    }

    public function getWhatsappContentAttribute()
    {
        return $this->title.'%0a%0a'.strip_tags($this->description).'%0a%0a'.$this->path();
    }

    public function getExtrasAttribute($value)
    {
        return collect(json_decode($value));
    }

    public function getLikeAttribute()
    {
        return $this->extras->get('like');
    }

    public function getDislikeAttribute()
    {
        return $this->extras->get('dislike');
    }

    public function getWhatsappAttribute()
    {
        return $this->extras->get('whatsapp');
    }

    public function getTelegramAttribute()
    {
        return $this->extras->get('telegram');
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setExtrasAttribute($values)
    {
        $this->attributes['extras'] = json_encode($values);
    }
    
    public function setLikeAttribute($value)
    {
        $this->extras = $this->extras->merge(['like' => $value]);
    }
    
    public function setDislikeAttribute($value)
    {
        $this->extras = $this->extras->merge(['dislike' => $value]);
    }

    public function setWhatsappAttribute($value)
    {
        $this->extras = $this->extras->merge(['whatsapp' => $value]);
    }
    
    public function setTelegramAttribute($value)
    {
        $this->extras = $this->extras->merge(['telegram' => $value]);
    }
}
