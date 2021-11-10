<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User as ModelsUser;

class User extends ModelsUser
{
    use HasFactory;

    public function routeNotificationForSmsir()
    {
        return $this->mobile;
    }
}
