<?php

namespace Rezahmady\Profile\Http\Controllers;

use Alert;

use App\Http\Livewire\Traits\WithAlert;
use App\Models\Ostan;
use App\Models\Shahrestan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Rezahmady\Filter\Models\FilterItem;


class Info extends Component
{

    use RepeatableFields, WithFileUploads, WithAlert;

    public $user;

    public $photo;

    public $name;

    public $sex;

    public $bio;

    public $email;

    public $edu_bg = [];

    public $job_bg = [];
    
    public $gif_bg = [];
    
    public $ostans = [];

    public $shahrestans = [];

    public $ostan;

    public $shahrestan;
    
    public $address;
    
    public $services;

    public $new_services;

    public $medical_code;

    public $experience;

    public $specialty_id;

    public $filters;

    public function mount()
    {
        $this->user = backpack_user()->withFakes();
        $this->name = $this->user->name;
        $this->sex = $this->user->sex;
        $this->email = $this->user->email;
        $this->bio = $this->user->bio;
        $this->address = $this->user->address;
        $this->medical_code = $this->user->medical_code;
        $this->experience = $this->user->experience;
        $this->specialty_id = $this->user->specialty_id;
        $this->services = $this->getServicesProperty();
        $this->new_services = json_decode($this->user->services,true);
        $this->edu_bg = json_decode($this->user->edu_bg);
        $this->job_bg = json_decode($this->user->job_bg);
        $this->gif_bg = json_decode($this->user->gif_bg);


        // arrays for select
        $this->ostans = Ostan::pluck('name','id');
        $this->ostan = $this->user->ostan;
        $this->shahrestan = $this->user->shahrestan;
        $this->shahrestans = ($this->user->ostan) ? Shahrestan::where('ostan_id', $this->ostan)->pluck('name', 'id') : [null => '--ابتدا استان را انتخاب کنید--'];
        $this->filters = FilterItem::where('filter_id', 6)->get()->pluck('name','id')->toArray();
        // dd($this->services);
    }

    public function getServicesProperty()
    {
        $services = json_decode($this->user->services, true);
        if(is_array($services)) {
            $values = [];
            foreach($services as $item) {
                $values[] = $item['text'];
            }
            return $values;
        }
        return [];
    }

    public function setServices()
    {
        $services = $this->services;
        if(is_array($services)) {
            $values = [];
            foreach($services as $item) {
                $values[]['text'] = $item;
            }
            return $values;
        }
        return [];
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);
    }

    function rules() {
        return [
            'name'  => 'required|string|min:2',
            'email' => 'email|unique:users,email,'.$this->user->id,
            'sex'   => 'required',
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('update-components');
        $this->dehydrateWithAlert();
    }

    public function updatedOstanId()
    {
        $this->shahrestans = Shahrestan::where('ostan_id', $this->ostan)->pluck('name', 'id');
    }

    public function submit()
    {
        // dd($this->setServices());
        $this->validate();
        // upload photo
        $photo = $this->user->extras->profile;
        if($this->photo) {
            $resource = "/livewire/preview-file/{$this->photo->getFilename()}";
            $destination = '/uploads/images/user/'.$this->photo->getFilename();
            if(Storage::disk('local')->exists($resource)) Storage::disk('local')->move($resource, $destination);
            $photo = $destination;
        }
        $this->photo = null;
        
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'extras->bio' => $this->bio,
            'extras->sex' => $this->sex,
            'extras->edu_bg' => json_encode($this->edu_bg),
            'extras->job_bg' => json_encode($this->job_bg),
            'extras->gif_bg' => json_encode($this->gif_bg),
            'extras->ostan' => $this->ostan,
            'extras->shahrestan' => $this->shahrestan,
            'extras->address' => $this->address,
            'extras->profile'  => $photo,
            'extras->services'  => json_encode($this->setServices()),
            'extras->experience' => $this->experience,
            'extras->medical_code' => $this->medical_code,
            'extras->specialty_id' => $this->specialty_id,
        ]);
        Alert::success('تغییرات ذخیره شد')->flash();       
    }
    
    public function edu_bg()
    {
        return [
            'name' => '',
            'place' => '',
            'date' => '',
        ];
    }

    public function job_bg()
    {
        return [
            'name' => '',
            'duration' => '',
        ];
    }

    public function gif_bg()
    {
        return [
            'date' => '',
            'name' => '',
            'description' => '',
        ];
    }
    

    public function render()
    {
        return view('theme::modules.profile.info')->layout('theme::modules.profile.layouts.profile');
    }
}
