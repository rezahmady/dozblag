<?php

namespace Rezahmady\User\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormValidation extends Component
{
    public $view;

    public $validation_code;
    
    public $user;

    // protected $listeners = ['reset-form' => '$refresh'];

    public function mount()
    {
        session()->flash('success', "کد فعال سازی به شماره {$this->user->mobile} ارسال شد.");
    }

    protected function rules()
    {
        return [
            'validation_code' => 'required|string|max:10',
        ];
    }

    protected $validationAttributes = [
        'validation_code' => 'کد فعال سازی'
    ];

    public function submit()
    {
        // $this->validate();

        if ($this->validation_code == session('validation_code')) {
            
            // $userdata = array(
            //     'mobile'     => $this->user->mobile,
            //     'password'  => $this->validation_code
            // );
            $user = User::where('mobile', $this->user->mobile)->first();
            if($user) {
                Auth::loginUsingId($user->id);
            } else {
                session()->flash('error', 'سشن به اتمام رسیده مجدد تلاش کنید');
            }
            session()->forget('validation_code');

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

            // if (Auth::attempt($userdata, true)) {
            //     if(session('link')) {
            //         $url = session('link');
            //         session()->forget('link');
            //         return redirect()->to($url);
            //     }
            //     return redirect()->to('/');
            // } else {
            //     session()->flash('error', 'کد فعال سازی را اشتباه وارد کرده اید. لطفا دوباره سعی کنید');
            // }
            // Auth::loginUsingId($this->user->id);
        } else {
            session()->flash('error', 'کد فعال سازی را اشتباه وارد کرده اید. لطفا دوباره سعی کنید');
        }

        

        // attempt to do the login
        

    }

    public function resetForm()
    {
        $this->emitUp('reset-form-holder');
    }

    public function render()
    {
        return view($this->view);
    }
}
