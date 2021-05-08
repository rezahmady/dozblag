<?php

namespace Rezahmady\User\Http\Livewire\Auth;

use App\Models\User;
use App\Notifications\Sms\VerificationCode;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class FormLogin extends Component
{

    public $mobile;

    public $view;

    // protected $listeners = ['reset-form' => '$refresh'];

    protected function rules()
    {
        return [
            'mobile' => 'required|string|max:11|min:8',
        ];
    }

    protected $validationAttributes = [
        'mobile' => 'موبایل'
    ];

    public function submit()
    {
        $this->validate();
        // CreateRegisterCode
        $validation_code = rand(99999, 1000000);

        $user = User::where('mobile', $this->mobile)->first();
        if(!$user) {
            $user = User::create([
                'mobile'       => $this->mobile,
                'password'       => Hash::make($validation_code),
            ]);
        } else {
            $user->update([
                'password'       => Hash::make($validation_code),
            ]);
        }
        
        //send SMS
        $user->notify(new VerificationCode($validation_code));
        
        //save validation_code in session
        session()->forget('validation_code');
        session([
            'validation_code' => $validation_code,
            'mobile'          => $this->mobile    
        ]);

        $this->emitUp('added-user', $user);
    }

    public function render()
    {
        return view($this->view);
    }
}
