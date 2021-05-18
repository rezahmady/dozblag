<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Telegram\Telegram;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public $chat_id;

    public $user_id;

    public $option = false;

    public $text;

    public $telegram;

    public function index()
    {
        
        try {
            $this->telegram = new Telegram(env('TELEGRAM_BOT_TOKEN'));
            $result = $this->telegram->getData();
            $this->text = $result['message']['text'];
            $this->chat_id = $result['message']['chat']['id'];
            if($this->text == "/start") return $this->start();
            if($this->text != "/start") return $this->login();

        } catch (\Throwable $th) {
            return redirect()->to('/');
        }
    }

    public function start()
    {
        $message = "به بات اطلاع رسانی گرین خوش آمدید . لطفا شماره موبایل خود را برای ورود وارد کنید";
        $content = array('chat_id' => $this->chat_id, false, 'text' => $message);
        $this->telegram->sendMessage($content);
    }

    public function login()
    {
        $option = false;
        try {
            $user = User::findByMobile($this->text);
            if($user) {
                $user->update([
                    'extras->telegram_user_id' => $this->chat_id
                ]);
                $message = 'بات تلگرامی برای حساب کاربری شما با موفقیت فعال شد';
            } else {
                $message = 'کاربری با این شماره موبایل در سایت ثبت نام نشده';
                $option = [
                    [
                        $this->telegram->buildInlineKeyBoardButton("ثبت نام", route('auth.login')),
                        $this->telegram->buildKeyboardButton("ورود")
                    ]
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
            $message = $th->getMessage();
        }

        
        $keyb = ($option) ? $this->telegram->buildKeyBoard($option, $onetime=false) : false;
        $content = array('chat_id' => $this->chat_id, 'reply_markup' => $keyb, 'text' => $message);
        $this->telegram->sendMessage($content);
    }
}
