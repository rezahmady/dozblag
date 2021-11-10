<?php

namespace Modules\Payment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Rezahmady\SettingOperation\Facades\Setting;

class PaymentConfigs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->overrideConfigValues();
        return $next($request);
    }

    protected function overrideConfigValues()
    {
        $config = [];
        $config['payment.default'] = Setting::get('transactions.default_driver');

        // zarinpal
        $config['payment.drivers.zarinpal.merchantId'] = Setting::get('transactions.zarinpal_merchantId');
        $config['payment.drivers.zarinpal.mode'] = Setting::get('transactions.zarinpal_mode');
        $config['payment.drivers.zarinpal.callbackUrl'] = url('/callback');

        // idpay
        $config['payment.drivers.idpay.merchantId'] = Setting::get('transactions.idpay_merchantId');
        $config['payment.drivers.idpay.sandbox'] = Setting::get('transactions.idpay_sandbox');
        $config['payment.drivers.idpay.callbackUrl'] = url('/callback');

        //behpardakht
        $config['payment.drivers.behpardakht.terminalId'] = Setting::get('transactions.behpardakht_terminalId');
        $config['payment.drivers.behpardakht.username'] = Setting::get('transactions.behpardakht_username');
        $config['payment.drivers.behpardakht.password'] = Setting::get('transactions.behpardakht_password');
        $config['payment.drivers.behpardakht.callbackUrl'] = url('/callback');

        // saman
        $config['payment.drivers.saman.merchantId'] = Setting::get('transactions.saman_merchantId');
        $config['payment.drivers.saman.callbackUrl'] = url('/callback');

        config($config);

    }
}
