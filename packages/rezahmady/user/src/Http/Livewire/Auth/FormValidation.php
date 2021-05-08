<?php

namespace Rezahmady\User\Http\Livewire\Auth;

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
            session()->forget('validation_code');
            $userdata = array(
                'mobile'     => $this->user->mobile,
                'password'  => $this->validation_code
            );

            if (Auth::attempt($userdata, true)) {
                return redirect()->to('/');
            } else {
                session()->flash('error', 'کد فعال سازی را اشتباه وارد کرده اید. لطفا دوباره سعی کنید');
            }
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
