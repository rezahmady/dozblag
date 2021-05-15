<?php

namespace Rezahmady\Payment\Traits;

use Rezahmady\Payment\Models\Invoice;

trait HasPayment
{

    abstract public static function callbackPayment($status, $message);

    abstract public static function runAfterSettled(Invoice $invoice);
    
    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

}
