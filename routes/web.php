<?php

use App\Http\Controllers\FormController;
use App\Http\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PageRender;
use App\Http\Livewire\PostRender;
use App\Http\Livewire\Product\Show;
use App\Http\Livewire\User\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\UploadController;
use App\Http\Livewire\User\Auth\Login;
use App\Http\Livewire\User\Auth\Register;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/test', function() {
//     $volumeId = 'elf_l1_';
//     $path = 'images/filter'; // without root path
//     //$path = 'path\\to\\target'; // use \ on windows server
//     return $hash = $volumeId . rtrim(strtr(base64_encode($path), '+/=', '-_.'), '.');
// });
Route::get('/fire', function () {
    // event(new \App\Events\SystemMessage());
    // return 'ok';
    $user = App\Models\User::first();
    $user->notify(new App\Notifications\InvoicePaid());
});
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
Route::get('/pay', function () {
   
    $invoice = (new Invoice)->amount(1000);
    // ->transactionId(2)
    // ->via('zarinpal');

    // return $invoice->getDriver();
    // $invoice->uuid(1)->
    // Purchase the given invoice.
    return Payment::purchase($invoice,function($driver, $transactionId) {
        // We can store $transactionId in database.
        // return $driver;
        // ddd($transactionId);
    })->pay()->render();
});
// At the top of the file.
Route::post('/upload/voice', [UploadController::class, 'voice']);
Route::get('/test', function () {
    $name = 'products.status';
    $model = config('setting-operation.setting_model_class', \Rezahmady\SettingOperation\app\Models\SettingOperation::class);
    $arr = explode('.',$name);
    $key = $arr[0];
    $field = $arr[1];
    $settings = $model::where('key', $key)->first();
    $fields = json_decode($settings->fields);
    if(property_exists($fields,$field)) {
        return $fields->{$field};
    }
    ddd($fields);
});

Route::any('/callback', function (Request $request) {
   if($request->Status === "OK") {
       // You need to verify the payment to ensure the invoice has been paid successfully.
       // We use transaction id to verify payments
       // It is a good practice to add invoice amount as well.
       $transaction_id = $request->Authority;

       try {
           $receipt = Payment::amount(1000)->transactionId($transaction_id)->verify();
   
           // You can show payment referenceId to the user.
        //    echo $receipt->getReferenceId();
           ddd($receipt);
   
       } catch (InvalidPaymentException $exception) {
           /**
               when payment is not verified, it will throw an exception.
               We can catch the exception to handle invalid payments.
               getMessage method, returns a suitable message that can be used in user interface.
           **/
          ddd($exception);
           echo $exception->getMessage();
       }
   }

});

Route::get('/', Home::class)->name('home');
// Download Route
Route::get('download', function(Request $request)
{
    $filename = $request->filename;

    // Check if file exists in app/storage/file folder
    $file_path = public_path($filename)  ;
    // ddd($file_path);
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, basename($filename), [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
});
// Route::get('/product/{product:slug}', Show::class)->name('product.show');
Route::post('/form/{page:id}', [FormController::class, 'save'])->name('form.save');

Route::group(['prefix'=>'auth','as'=>'auth.'], function() {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});
Route::get('/doctor/{user:id}', DoctorProfile::class)->name('doctor.show');

Route::get('mag/{article:slug}/{subs?}', PostRender::class)
    ->where(['article' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*'])->name('article');

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{modelPage}/{subs?}', PageRender::class)
    ->where(['modelPage' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*'])->name('page');

   



