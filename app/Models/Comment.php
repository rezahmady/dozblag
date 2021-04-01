<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\ModelCommonMethods;

class Comment extends Model
{
    use HasFactory;
    use CrudTrait, ModelCommonMethods;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['parent_id', 'user_id', 'body', 'module', 'module_id', 'name', 'email', 'score', 'extras', 'status'];
    protected $fakeColumns = ['extras'];
    protected $casts = [
        // 'status'  => 'boolean',
        'extras'    => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id');
    }

    public function getModule()
    {
        $model = "\\App\\Models\\$this->module";
        return $this->belongsTo($model,'module_id', 'id');
    }
    
    public function children()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($comment) { // before delete() method call this
             $comment->children()->delete();
             // do the rest of the cleanup...
        });
    }

    public function getModuleParameter($attribute)
    {
        echo $this->getModule->{$attribute};
    }


    public function approvedComment()
    {
        if ($this->status !=1) {
            return '<a class="btn btn-sm btn-success" href="/admin/article/comment/'.$this->id.'/approvedComment">'.
                'تایید</a>';
        }
    }

    public function rejectComment()
    {
        if ($this->status !=2) {
            return '<a class="btn btn-sm btn-danger" href="/admin/article/comment/'.$this->id.'/rejectComment">'.
                'رد</a>';
        }
    }

    public function goToComment()
    {
        if ($this->status == 1) {
            $model = "\\App\\Models\\".$this->module;
            $module = $model::findOrFail($this->module_id);
            $route = $module->path();
            return '<a target="_blank" class="btn btn-sm btn-info" href="'.$route.'#comment_'.$this->id.'">'.
                'پاسخ</a>';
        }
    }

    public function getStatusShow()
    {
        switch ($this->status) {
            case 1:
                echo '<span class="badge badge-success badge-text">تایید نمایش </span>';
                break;
            case 2:
                echo '<span class="badge badge-danger badge-text">رد شده </span>';
                break;
            default:
                echo '<span class="badge badge-warning badge-text">بررسی نشده </span>';
                break;
        }
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
}
