<?php

namespace Modules\User\Http\Livewire;

use App\Events\ConsultationAdded;
use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;
use App\Models\User;
use App\Notifications\Doctor\NewRoom as DoctorNewRoom;
use App\Notifications\Operator\NewRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Chat\Models\Room;
use Modules\Payment\Models\Discount;
use Rezahmady\SettingOperation\Facades\Setting;
use Modules\Subscribtion\Models\Subscribtion;

class DoctorProfile extends Component
{
    use  WithAlert;

    public $doctor;

    public $clinics;

    public $edu_bg;

    public $job_bg;

    public $gif_bg;

    public $services;

    public $packages;

    public $gateways;

    public $driver;

    public $discount;

    public $discount_id = null;

    public $subscribtion;

    public $subscribtionStatus;

    public function mount(User $user) {

        $this->doctor   = $user->withFakes();

        $this->clinics  = $this->doctor->resource;

        $this->edu_bg   = json_decode($this->doctor->edu_bg, true);

        $this->job_bg   = json_decode($this->doctor->job_bg, true);

        $this->gif_bg   = json_decode($this->doctor->gif_bg, true);

        $this->services = $this->doctor->servicesFilter();

        $this->packages = $user->getDoctorSubscribtion();

        $this->subscribtion = Subscribtion::active()->first()->toArray();

        $this->gateways = Setting::get('transactions.drivers');

        $this->driver = Setting::get('transactions.default_driver');

        $this->subscribtionStatus = $this->checkSubscribtion();

    }

    public function checkSubscribtion()
    {
        if(Auth::check() and auth()->user()->hasSubscribtion()) {
            if (auth()->user()->hasSubscribtion()) {
                return 'access';
            }
        }
        return 'deny';
    }

    public function selectSubscribtion($id)
    {
        $this->subscribtion = Subscribtion::find($id)->toArray();
        $this->discount = $this->discount_id = null;

    }

    public function enrolement() {

        if(!auth()->check())
        {
            session(['paymentLink' => url()->previous()]);
            return redirect()->to(route('auth.login'));
        }
    }

    function rules() {
        return [
            'discount'  => 'required|exists:discounts,name',
        ];
    }

    public function checkDiscount()
    {
        $this->validate();
        $discount = Discount::Where('name', $this->discount)->first();
        // check used before
        $checkUniqueUsed = backpack_user()->invoices()->where('discount_id', $discount->id)->settled()->get();

        if(sizeOf($checkUniqueUsed)) {
            $this->addError('discount', 'این کدتخفیف قبلا استفاده شده');
        } else {
            if($this->discount_id != $discount->id)
                $this->subscribtion['amount'] = $discount->applayDiscount($this->subscribtion['amount']);
            $this->discount_id = $discount->id;
        }
    }

    public function payment(Subscribtion $subscribtion)
    {

        if(!auth()->check())
        {
            session(['paymentLink' => url()->previous()]);
            return redirect()->to(route('auth.login'));
        }

        $invoice = $subscribtion->invoice()->where('user_id', backpack_user()->id)->where('amount', $subscribtion->amount)->notsettled()->first();

        $amount = ($this->discount_id) ? Discount::find($this->discount_id)->applayDiscount($subscribtion->amount) : $subscribtion->amount;

        if($amount > 100) {
            if(!$invoice) {
                $invoice = $subscribtion->invoice()->create([
                    'user_id' => backpack_user()->id,
                    'amount'  => $amount,
                    'discount_id' => $this->discount_id,
                ]);
            } elseif($this->discount_id) {
                $invoice->update([
                    'discount_id' => $this->discount_id,
                ]);
            }

            $invoiceId = $invoice->id;
            $selected_driver = $this->driver;
            session()->put('doctor_id', $this->doctor->id);

            return redirect()->to("/payment/$selected_driver/$invoiceId");
        } else {
            $room = Room::create([
                'user_id' => backpack_user()->id,
                'doctor_id' => $this->doctor->id,
                'extras->subscribtion_id' => $subscribtion->id,
                'extras->remaining_duration' => $subscribtion->extras->limit_duration,
                'extras->expire_date' => null,
            ]);

            backpack_user()->subscribtions()->save($subscribtion, [
                'room_id'     => $room->id,
                'doctor_id'   => $this->doctor->id,
            ]);

            broadcast(new ConsultationAdded($room->id))->toOthers();

            // operator
            User::where('template', 'operator')->where('extras->telegram_user_id', '!=', null)->get()->each(function($user) use($room) {
                $user->notify(new NewRoom($room));
            });

            // doctor
            $doctor = User::where('id', session()->get('doctor_id'))->where('extras->telegram_user_id', '!=', null)->first();
            if($doctor)
            {
                $doctor->notify(new DoctorNewRoom($room));
            }
        }
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function render()
    {
        // dd($this->edu_bg);
        return view('theme::modules.user.doctor-profile')->layout('theme::layouts.app');
    }
}
