<?php

namespace Rezahmady\User\Models;

use App\Models\Ostan;
use App\Models\Shahrestan;
use App\Traits\SetJsonMutator;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rezahmady\Chat\Models\Room;
use Rezahmady\Comment\Models\Comment;
use Spatie\Permission\Traits\HasRoles;
use Rezahmady\Payment\Models\Invoice;
use Rezahmady\Payment\Models\Transaction;
use Rezahmady\Resource\Models\Resource;
use Rezahmady\Subscribtion\Models\Subscribtion;

class User extends Authenticatable
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use HasFactory, Notifiable, HasRoles, CrudTrait,SetJsonMutator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'password',
        'template',
        'extras',
        'extras->gender',
        'extras->bio',
        'extras->edu_bg',
        'extras->job_bg',
        'extras->gif_bg',
        'extras->ostan',
        'extras->shahrestan',
        'extras->address',
        'extras->profile',
        'extras->services',
        'extras->experience',
        'extras->medical_code',
        'extras->filter_specilty',
        'extras->filter_services',
        'extras->telegram_user_id',
        'extras->medical_folder',
    ];

    protected $fakeColumns = ['extras'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'extras'         => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent() {
        return $this->belongsTo(self::class);
    }

    public function relationBelongsTo()
    {
        return $this->belongsTo(self::class);
    }

    public function relationHasMany()
    {
        return $this->hasMany(self::class);
    }

    public function resource()
    {
        return $this->belongsToMany(Resource::class);
    }

    public function ostan()
    {
        return $this->belongsTo(Ostan::class, 'extras->ostan_id');
    }

    public function shahrestan()
    {
        return $this->belongsTo(Shahrestan::class, 'extras->shahrestan_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Invoice::class);
    }

    public function subscribtions()
    {
        return $this->belongsToMany(Subscribtion::class)->withPivot(['doctor_id']);
    }

    public function getActiveSubscribtions()
    {
        // return $this->subscribtions()->wherePivot('expire_date', '>=', Carbon::now())->orWhere('expire_date', null);
        return $this->subscribtions()->with(['room' => function($q) {
            $q->where('extras->expire_date', '>=', Carbon::now())->orWhere('extras->expire_date', null);
        }]);
    }

    public function hasSubscribtion()
    {
        // $subscribtion = $this->subscribtions()->wherePivot('expire_date', '>=', Carbon::now())->orWhere('expire_date', null)->first() ;
        $subscribtion = $this->subscribtions()->with(['room' => function($q) {
            $q->where('extras->expire_date', '>=', Carbon::now())->orWhere('extras->expire_date', null);
        }])->first();
        return (isset($subscribtion->name)) ? true : false;
    }
    
    public function getSubscribtionBrowse()
    {
        $subscribtion = $this->getActiveSubscribtions()->first();
        if(isset($subscribtion->name)) {
            echo $subscribtion->name;
        } else {
            echo '-';
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id')->with('childrenRecursive')->where('parent_id', null);
    }

    public function getDoctorSubscribtion()
    {
        return Subscribtion::get()->filter(function($subs) {
            if(isset($this->extras->doctor_subscribtion))
                return in_array($subs->id, $this->extras->doctor_subscribtion) ;
            return false;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function username()
    {
        return 'mobile';
    }

    public function path()
    {
        return route('doctor.show', $this->id);
    }

    public function getPageLink()
    {
        return url('doctor/'.$this->id);
    }

    public function getOpenButton()
    {
        if($this->template === 'doctor') {
            return '<a class="btn btn-sm btn-link" href="'.$this->getPageLink().'" target="_blank">'.
                '<i class="la la-eye"></i> نمایش</a>';
        }
        return '';
    }

    public function getLoginAsButton($crud = false)
    {
        return '<a class="btn btn-sm btn-link" href="'.url('/admin/user/loginAsUser', $this->id).'" target="_blank">'.
            '<i class="la la-key"></i> ورود</a>';
        return '';
    }

    public function hasTemplate($template)
    {
        if(is_array($template)) {
            return in_array($this->template, $template);
        }
        return $this->template == $template;//or $this->hasRole(trans("rezahmady.user::permissionmanager.function_name.{$template}")
    }

    
    public function getProfile()
    {
        $image = 'assets/garrin/img/user.svg';
        if($this->template == 'doctor') {
            if($this->extras->gender == 'fmail') {
                $image = '/uploads/images/themes/garrin/doctor-woman.svg';
            } else {
                $image = '/uploads/images/themes/garrin/doctor-man.svg';
            }
        }
        $src = $this->extras->profile ?? $image;
        return asset($src);
    }

    public function routeNotificationForTelegram()
    {
        return $this->telegram_user_id;
    }

    public function getRoom($doctor)
    {
        return $this->rooms()->where('doctor_id', $doctor)->where(function($q) {
            $q->where('extras->expire_date', '>=', Carbon::now())->orWhere('extras->expire_date', null);
        })->first();
    }

    public function getRoomMd5Id($doctor) {
        return md5($this->getRoom($doctor)->id);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // public function setExtrasAttribute($values)
    // {
    //     // dd($values);
    //     // or use your own disk, defined in config/filesystems.php
    //     $disk = config('backpack.base.root_disk_name');
    //     // destination path relative to the disk above
    //     $destination_path = "public/uploads/images/user/";

    //     foreach($values as $attribute => $value)
    //     {
    //         if(Str::startsWith($attribute, 'filter_')) {
    //             // $values[$attribute] = json_encode($value);
                
    //         }
    //         elseif (Str::startsWith($value, 'data:image')){

    //             // 0. Make the image
    //             $image = Image::make($value)->encode('jpg', 90);

    //             // 1. Generate a filename.
    //             $filename = md5($value.time()).'.jpg';

    //             // 2. Store the image on disk.
    //             Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

    //             // 3. Delete the previous image, if there was one.
    //             if(isset($this->extras->$attribute)) Storage::disk($disk)->delete('/public/'.$this->extras->$attribute);

    //             // 4. Save the public path to the database
    //             // but first, remove "public/" from the path, since we're pointing to it
    //             // from the root folder; that way, what gets saved in the db
    //             // is the public URL (everything that comes after the domain name)
    //             $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
    //             $values[$attribute] = $public_destination_path.$filename;
    //         }
    //         elseif ($value == null) {
    //             // delete the image from disk
    //             Storage::disk($disk)->delete($this->{$attribute});
    //         }
    //     }

    //     // dd(json_encode($values));
    //     $this->attributes['extras'] = $values;
    // }
}
