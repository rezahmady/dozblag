<?php

namespace Modules\Subscribtion\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Models\Invoice;
use Modules\Payment\Traits\HasPayment;
use Alert;
use App\Events\ConsultationAdded;
use App\Models\User;
use App\Notifications\Operator\NewRoom;
use App\Notifications\Doctor\NewRoom as DoctorNewRoom;
use Modules\Chat\Models\Room;

class Subscribtion extends Model
{
    use CrudTrait, HasPayment;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subscribtions';
    protected $fillable = ['name', 'description', 'amount', 'extras'];
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $fakeColumns = ['extras'];
    protected $casts = [
        'extras' => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getAmount()
    {
        return number_format($this->amount);
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->extras->status) {
            case 1:
                $status = '<span class="badge badge-success center">منتشر شده</span>';
                break;
            case 0:
                $status = '<span class="badge badge-danger center">عدم انتشار</span>';
                break;

            default:
                # code...
                break;
        }
        echo $status;
    }

    public function runAfterSettled(Invoice $invoice)
    {
        $room = Room::create([
            'user_id' => backpack_user()->id,
            'doctor_id' => session()->get('doctor_id') ?? null,
            'extras->subscribtion_id' => $this->id,
            'extras->remaining_duration' => $this->extras->limit_duration,
            'extras->expire_date' => null,
        ]);

        backpack_user()->subscribtions()->save($this, [
            'room_id'     => $room->id,
            'doctor_id'   => session()->get('doctor_id'),
        ]);

        broadcast(new ConsultationAdded($room->id))->toOthers();

        // operator
        User::where('template', 'operator')->where('extras->telegram_user_id', '!=', null)->get()->each(function($user) use($room) {
            try {
                $user->notify(new NewRoom($room));
            } catch (\Throwable $th) {
                //throw $th;
            }
        });

        // doctor
        $doctor = User::where('id', session()->get('doctor_id'))->where('extras->telegram_user_id', '!=', null)->first();
        if($doctor)
        {
            try {
                $doctor->notify(new DoctorNewRoom($room));
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    public function callbackPayment($status, $message)
    {
        if($status == 'OK') {
            Alert::success($message)->flash();
        } else {
            Alert::error($message)->flash();
        }
        $url = session('callbackUrl');
        return redirect()->to($url);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function room()
    {
        return $this->hasOne(Room::class, 'extras->subscribtion_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('extras->status', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
