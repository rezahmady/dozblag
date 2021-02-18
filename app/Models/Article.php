<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Article extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['slug', 'title', 'content', 'image', 'status', 'featured','user_id', 'extras'];
    protected $fakeColumns = ['extras'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
        'extras'    => 'object',
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
                'source' => 'slug_or_title',
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'article_tag');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class)->with('parentRecursive');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id')->with('childrenRecursive')->where('parent_id', null);
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
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    public function getWhatsappContentAttribute()
    {
        return $this->title.'%0a%0a'.$this->description.'%0a%0a'.$this->path();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
