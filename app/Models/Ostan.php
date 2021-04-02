<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ostan extends Model
{
    use HasFactory;

    protected $table = 'ostans';

    public function shahrestans()
    {
        return $this->hasMany(Shahrestan::class, 'id');
    }
}
