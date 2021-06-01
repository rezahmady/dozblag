<?php

namespace Rezahmady\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Rezahmady\Payment\Models\Invoice as ModelsInvoice;
use Rezahmady\Payment\Models\Transaction;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{
    public function payment($driver, ModelsInvoice $invoice)
    {

        session(['callbackUrl' => url()->previous()]);
        $invoiceId = $invoice->id;
        $selected_driver = $driver;
        $amount = $invoice->amount;

        // applay discount
        if($invoice->discount) {
            $amount = $invoice->discount->applayDiscount($amount);
        }
        
        $invoice = (new Invoice)->amount($amount)->via($selected_driver);
        
        // Purchase the given invoice.
        return Payment::purchase($invoice,function($driver, $transactionId) use ($invoiceId, $amount, $selected_driver) {
            // We can store $transactionId in database.
            Transaction::create([
                'invoice_id' => $invoiceId,
                'driver'    => $selected_driver,
                'amount'    => $amount,
                'transactionId' => $transactionId
            ]);

        })->pay()->render();
    }

    public function callback(Request $request)
    {
        if($request->Status === "OK") {

            // You need to verify the payment to ensure the invoice has been paid successfully.
            // We use transaction id to verify payments
            // It is a good practice to add invoice amount as well.
            $transaction_id = $request->Authority;

            $transaction = Transaction::where('transactionId', $transaction_id)->first();
     
            try {
                $receipt = Payment::amount($transaction->amount)->transactionId($transaction_id)->verify();
                // You can show payment referenceId to the user.
                $transaction->update([
                    'date' => $receipt->getDate()->format('Y-m-d H:i:s'),
                    'referenceId' => $receipt->getReferenceId(),
                    'status' => 1,
                ]);
                // increment discount use
                if($transaction->invoice->discount) {
                    $transaction->invoice->discount->increment('use', 1);
                }
                
                $transaction->invoice->invoiceable->runAfterSettled($transaction->invoice);
                $message = "پرداخت با موفقیت انجام شد";
                return $transaction->invoice->invoiceable->callbackPayment($request->Status, $message);
        
            } catch (InvalidPaymentException $exception) {

                /**
                    when payment is not verified, it will throw an exception.
                    We can catch the exception to handle invalid payments.
                    getMessage method, returns a suitable message that can be used in user interface.
                **/
                $message = $exception->getMessage();
                $status = "ERROR";
                return $transaction->invoice->invoiceable->callbackPayment($status, $message);
            }
        } else {
            
            $transaction_id = $request->Authority;
            $transaction = Transaction::where('transactionId', $transaction_id)->first();

            try {
                $receipt = Payment::amount($transaction->amount)->transactionId($transaction_id)->verify();        
            } catch (InvalidPaymentException $exception) {
                
                /**
                    when payment is not verified, it will throw an exception.
                    We can catch the exception to handle invalid payments.
                    getMessage method, returns a suitable message that can be used in user interface.
                **/
                $message = $exception->getMessage();
                return $transaction->invoice->invoiceable->callbackPayment($request->Status, $message);
            }
            
            
        }
    }
}
