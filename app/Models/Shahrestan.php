<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shahrestan extends Model
{
    use HasFactory;

    protected $table = 'shahrestans';

    public function ostan()
    {
        return $this->belongsTo(Ostan::class, 'ostan_id');
    }
}
