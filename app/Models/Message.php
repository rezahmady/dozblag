<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Rezahmady\Page\Models\Page;

class Message extends Model
{
    use CrudTrait;

    protected $table = 'messages';
    protected $fillable = ['subject', 'content', 'form_id', 'user_id', 'extras', 'status', 'type', 'from', 'to'];
    protected $fakeColumns = ['extras'];
    protected $casts = [
        'extras' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function form()
    {
        return $this->belongsTo(Page::class, 'form_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getStatus() {

        $status = null;

        switch ($this->status) {
            case '1':
                $status = '<span class="badge badge-success center">خوانده شده</span>';
                break;
            case '0':
                $status = '<span class="badge badge-warning center">خوانده نشده</span>';
                break;
            
            default:
                # code...
                break;
        }
        echo $status;
    }

    public function getType() {
        $status = null;

        switch ($this->type) {
            case 'public':
                $status = 'پیام های عمومی';
                break;
            case 'system':
                $status = 'پیام های سیستمی';
                break;
            case 'form':
                $status = 'تکمیل فرم';
                break;
            
            default:
                # code...
                break;
        }
        echo $status;
    }

    public function setStatusFalse()
    {
        return '<a class="btn btn-sm btn-link" href="/admin/message/'.$this->id.'/toggleSeen">'.
            '<i class="la la-eye-slash"></i> خوانده نشده</a>';
    }
}
