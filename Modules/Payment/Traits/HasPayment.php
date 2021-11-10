<?php

namespace Modules\Payment\Traits;

use Modules\Payment\Models\Invoice;

trait HasPayment
{

    abstract public function callbackPayment($status, $message);

    abstract public function runAfterSettled(Invoice $invoice);

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

}
