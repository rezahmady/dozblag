<?php

namespace Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Comment\Models\Comment;
use Modules\Subscribtion\Models\Subscribtion;
use Modules\User\Models\User;

class Room extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use HasFactory, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'extras->remaining_duration',
        'extras->subscribtion_id',
        'extras->expire_date',
        'operator_id',
        'doctor_id',
        'user_id',
        'extras',
        'status',
    ];

    protected $fakeColumns = ['extras'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extras'         => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function messages()
    {
        return $this->hasMany(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function audience()
    {
        if(auth()->user()->template === 'customer') {
            if($this->doctor_id) {
                return $this->doctor();
            }
            return $this->operator();
        } else {
            if($this->user_id !== auth()->id()) {
                return $this->user();
            }
            if($this->operator_id) {
                return $this->operator();
            }
            return $this->doctor();
        }
    }

    public function latestMessage()
    {
        return $this->hasOne(Chat::class)->latest();
    }

    public function subscribtion()
    {
        return $this->belongsTo(Subscribtion::class, 'extras->subscribtion_id');
    }

    public function comment()
    {
        return $this->hasOne(Comment::class, 'extras->room_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function resetRoom()
    {
        return '<a class="btn btn-sm btn-link" href="/admin/reset-room/'.$this->id.'">'.
            '<i class="la la-redo-alt"></i>تمدید</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // public function setExtrasAttribute($value)
    // {
    //     $this->attributes['extras'] = $value ? $value->toJson() : json_encode([]);
    // }

    public function getExtrasAttribute($value)
    {
        return collect(json_decode($value));
    }

    public function getStatusAttribute()
    {
        return $this->extras->get('status');
    }


    public function setStatusAttribute($value)
    {
        $this->extras = $this->extras->merge(['status' => $value]);
    }

}
