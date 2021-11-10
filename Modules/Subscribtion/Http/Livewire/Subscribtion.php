<?php

namespace Modules\Subscribtion\Http\Livewire;

use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;
use Modules\Payment\Models\Discount;
use Rezahmady\SettingOperation\Facades\Setting;
use Modules\Subscribtion\Models\Subscribtion as ModelsSubscribtion;

class Subscribtion extends Component
{
    use  WithAlert;

    public $packages;

    public $widget;

    public $gateways;

    public $driver;

    public $discount;

    public $discount_id = null;

    public $amount = 0;

    protected $listeners = ["widget-updated:self-page" => '$refresh', 'update-widget' => 'widgetUpdate'];

    public function widgetUpdate()
    {
        $this->emit("widget-updated:{$this->widget}");
    }

    public function mount()
    {
        $this->packages = ModelsSubscribtion::active()->get();
        $this->gateways = Setting::get('transactions.drivers');
        $this->driver = Setting::get('transactions.default_driver');
    }

    function rules() {
        return [
            'discount'  => 'exists:discounts,name',
        ];
    }

    public function checkDiscount()
    {
        $this->validate();
        $discount = Discount::Where('name', $this->discount)->first();
        // check used before
        $checkUniqueUsed = backpack_user()->invoices()->where('discount_id', $discount->id)->settled()->get();
        // dd($checkUniqueUsed);
        if(sizeOf($checkUniqueUsed)) {
            $this->addError('discount', 'این کدتخفیف قبلا استفاده شده');
        } else {
            if($this->discount_id != $discount->id)
                $this->amount = $discount->applayDiscount($this->amount);
            $this->discount_id = $discount->id;
        }
    }

    public function payment(ModelsSubscribtion $subscribtion)
    {

        $invoice = $subscribtion->invoice()->where('user_id', backpack_user()->id)->where('amount', $subscribtion->amount)->notsettled()->first();

        if(!$invoice) {
            $invoice = $subscribtion->invoice()->create([
                'user_id' => backpack_user()->id,
                'amount'  => $subscribtion->amount,
                'discount_id' => $this->discount_id,
            ]);
        } elseif($this->discount_id) {
            $invoice->update([
                'discount_id' => $this->discount_id,
            ]);
        }

        $invoiceId = $invoice->id;
        $selected_driver = $this->driver;

        return redirect()->to("/payment/$selected_driver/$invoiceId");
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function render()
    {
        return view('theme::modules.subscribtion.index')->layout('theme::layouts.app-state');
    }
}
