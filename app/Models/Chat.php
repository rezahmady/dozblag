<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Verta;

class Chat extends Model
{
    use HasFactory, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id',
        'room_id',
        'parent_id',
        'seen',
        'type',
    ];

    // protected $fakeColumns = ['extras'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'seen'         => 'boolian',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function parent()
    {
        return $this->belongsTo(Self::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    
    public function getDateFullAttribute()
    {
        $date = new Verta($this->created_at);
        return $date->format('H:i Y/n/j');
    }

    public function getDateAttribute()
    {
        $date = new Verta($this->created_at);
        return $date->format('Y/n/j');
    }

    public function getTimeAttribute()
    {
        $date = new Verta($this->created_at);
        return $date->format('H:i');
    }

    


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    
}