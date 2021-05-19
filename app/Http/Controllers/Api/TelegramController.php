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
            $this->telegram = new Telegram('1640783878:AAHrfX9BFkE1o2IKBf7smvkQxI61cQzdncs');
            $result = $this->telegram->getData();
            $this->text = $result['message']['text'];
            $this->chat_id = $result['message']['chat']['id'];
            if($this->text == "/start") return $this->start();
            if($this->text == "ورود") return $this->start();
            if($this->text != "/start") return $this->login();

        } catch (\Throwable $th) {
            return redirect()->to('/');
        }
    }

    public function start()
    {
        $message = "به بات اطلاع رسانی گرین خوش آمدید . لطفا شماره موبایل خود را برای ورود وارد کنید";
        $content = array('chat_id' => $this->chat_id, 'text' => $message);
        $this->telegram->sendMessage($content);
    }

    public function login()
    {
        $option = false;
        try {
            $user = User::where('mobile', $this->text)->first();
            if($user) {
                $user->update([
                    'extras->telegram_user_id' => $this->chat_id
                ]);
                $message = 'بات تلگرامی برای حساب کاربری شما با موفقیت فعال شد';
                // $option = [
                //     [
                //         $this->telegram->buildKeyBoardButton("ثبت نام"),
                //         $this->telegram->buildKeyBoardButton("ورود")
                //     ]
                // ];
                // $keyb =  $this->telegram->buildKeyBoard($option, $onetime=false,$resize=true);
            } else {
                $message = 'کاربری با این شماره موبایل در سایت ثبت نام نشده.
درصورتی که شماره را اشتباه وارد کرده اید مجددا شماره موبایل خود را به طور صحیح وارد کنید.
و در صورتی که هنوز در سایت ثبت نام نکرده اید از طریق لینک زیر ثبت نام کنید
                ';
                $option = [
                    [
                        $this->telegram->buildInlineKeyBoardButton("ثبت نام", route('auth.login'))
                    ]
                ];
                $keyb =  $this->telegram->buildInlineKeyBoard($option);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $message = $th->getMessage();
        }

        
        $keyb = ($option) ? $keyb: false;
        $content = array('chat_id' => $this->chat_id, 'reply_markup' => $keyb, 'text' => $message);
        $this->telegram->sendMessage($content);
    }
}
