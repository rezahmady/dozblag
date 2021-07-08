<?php

namespace Rezahmady\User\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Rezahmady\Smsir\SmsirMessage;
use Alert;
use App\Http\Livewire\Traits\WithAlert;

class Login extends Component
{
    use WithAlert;

    public $user = null;

    public $step = 1;

    public $mobile;

    public $password;

    public $remember;

    public $new;

    public $validation_code;

    public function mount()
    {
        if(session()->has('validation_code') and session()->has('mobile')) {
            $this->user = User::where('mobile', session('mobile'))->first();
            $this->step = 2;
        }
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function resetForm()
    {
        session()->forget('validation_code');
        session()->forget('mobile');
        $this->user = $this->mobile = null;
        $this->step = 1;
    }

    protected $validationAttributes = [
        'mobile' => 'موبایل',
        'validation_code' => 'کد فعال سازی'
    ];

    public function loginByPass() {
        $this->step = 4;
    }

    public function send_mobile()
    {
        $this->validate([
            'mobile' => 'required|string|max:11|min:10',
        ]);

        // CreateRegisterCode
        $validation_code = rand(99999, 1000000);
        
        $user = User::where('mobile', $this->mobile)->first();
        if(!$user) {
            $user = User::create([
                'mobile'       => $this->mobile,
                'password'       => Hash::make($validation_code),
            ]);
            $this->new = true;
        }
        
        //send SMS
        $sms = (new SmsirMessage())
            ->setMethod('ultraFastSend')
            ->setTemplateId('47119')
            ->setTo($user->mobile)
            ->setParameters([
                'VerificationCode' => $validation_code
            ])->trigger();

        if($sms->isSuccessful) {
            //save validation_code in session
            session()->forget('validation_code');
            session()->forget('mobile');
            session([
                'validation_code' => $validation_code,
                'mobile'          => $this->mobile    
            ]);
            $this->nextStep($user);
        } else {
            if($this->new) {
                $user->delete();
            }
            $this->addError('mobile', 'شماره وارد شده صحیح نیست.');
        }
        
    }

    public function send_code()
    {
        $this->validate([
            'validation_code' => 'required|string|max:10',
        ]);

        if ($this->validation_code == session('validation_code')) {
            
            $user = $this->user;
            if($user) {
                Auth::loginUsingId($user->id);
            } else {
                $this->step = 1;
                session()->flash('error', 'سشن به اتمام رسیده مجدد تلاش کنید');
            }
            session()->forget('validation_code');

            if($this->new) {
                $this->step = 3;
            } else {
                $this->step = 1;
                if(session('paymentLink')) {
                    $url = session('paymentLink');
                    session()->forget('paymentLink');
                    return redirect()->to($url);
                } elseif(session('link')) {
                    $url = session('link');
                    session()->forget('link');
                    return redirect()->to($url);
                }
                return redirect()->to('/');
            }
        } else {
            session()->flash('error', 'کد فعال سازی را اشتباه وارد کرده اید. لطفا دوباره سعی کنید');
        }
    }

    public function send_password()
    {
        $this->validate([
            'password' => 'required|string|max:10|min:4',
        ]);

        $user = $this->user;
        if($user) {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
            Alert::success('رمز عبور با موفقیت ذخیره شد')->flash();
            $this->step = 1;
            if(session('paymentLink')) {
                $url = session('paymentLink');
                session()->forget('paymentLink');
                return redirect()->to($url);
            } elseif(session('link')) {
                $url = session('link');
                session()->forget('link');
                return redirect()->to($url);
            }
            return redirect()->to('/');
        } else {
            $this->step = 1;
            session()->flash('error', 'سشن به اتمام رسیده مجدد تلاش کنید');
        }
    }

    public function login()
    {
        $this->validate([
            'mobile' => 'required|string|max:11|min:10',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['mobile'=>$this->mobile,'password'=>$this->password], $this->remember)){
            $this->step = 1;
            if(session('paymentLink')) {
                $url = session('paymentLink');
                session()->forget('paymentLink');
                return redirect()->to($url);
            } elseif(session('link')) {
                $url = session('link');
                session()->forget('link');
                return redirect()->to($url);
            }
            return redirect()->to('/');
        } else {
            session()->flash('error', 'شماره موبایل و یا رمز عبور اشتباه است');
        }

    }

    public function forgetPassword()
    {
        $this->step = 1;
        $this->new = true;
    }

    // public function 

    public function nextStep(User $user)
    {
        // dd($user);
        $this->user = $user;
        $this->step = 2;
        session()->flash('success', "کد فعال سازی به شماره {$user->mobile} ارسال شد.");
    }

    public function render()
    {
        return view('theme::modules.user.auth.login')->layout('theme::layouts.app');
    }
}
