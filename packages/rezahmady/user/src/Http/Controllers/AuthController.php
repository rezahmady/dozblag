<?php

namespace Rezahmady\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
