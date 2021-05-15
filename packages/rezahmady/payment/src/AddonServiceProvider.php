<?php

namespace Rezahmady\Payment;

use Illuminate\Support\ServiceProvider;
use Rezahmady\Payment\Http\Middleware\PaymentConfigs;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'payment';
    protected $commands = [];

    public function moduleBoot() : void
    {
        $this->app['router']->aliasMiddleware('payment-configs', PaymentConfigs::class);
    }

    public function moduleRegister() : void
    {
        //
    }

    public function menuBuilder($menu)
    {
        if(backpack_user()->can('payment management')){
            $menu->add('payment', trans('rezahmady.payment::payment.payment_menu_title') , '#' , 600 , 'dollar-sign');
            $menu->add('payment.invoice', trans('rezahmady.payment::payment.invoice_plural') , backpack_url('invoice') , 610, 'file-invoice-dollar');
            $menu->add('payment.transaction', trans('rezahmady.payment::payment.transaction_plural') , backpack_url('transaction') , 620, 'funnel-dollar');
            $menu->add('payment.discount', trans('rezahmady.payment::payment.discount_plural') , backpack_url('discount') , 630, 'ticket-alt');
        }
    }
}
