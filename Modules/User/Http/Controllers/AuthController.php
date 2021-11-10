<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logout();
        if (session('LoginOperatorAsUser')) {
            $adminId = session('LoginOperatorAsUser');
            Auth::loginUsingId($adminId);
            session()->forget('LoginOperatorAsUser');
            $message = 'شما به پنل خود بازگشتید';
            Alert::success($message)->flash();
            return redirect('/admin/user');
        }
        return redirect('/');
    }

    public function loginOperatorAsUser(User $user)
    {
        $adminId = Auth::id();
        session(['LoginOperatorAsUser' => $adminId ]);

        Auth::logout();
        Auth::loginUsingId($user->id);


        if ($user->template == 'operator') {
            $message = 'شما در قالب اپراتور وارد شدید برای بازگشت به پنل مدیریت کافی است از حساب این کاربر خارج شوید';
        } else {
            $message = 'شما در قالب مشتری وارد شدید برای بازگشت به پنل مدیریت کافی است از حساب این کاربر خارج شوید';
        }
        Alert::success($message)->flash();
        return redirect('/');
    }


}
