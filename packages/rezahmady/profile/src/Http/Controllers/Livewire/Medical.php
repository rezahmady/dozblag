<?php

namespace Rezahmady\Profile\Http\Controllers\Livewire;


use Alert;

use Rezahmady\Profile\Http\Controllers\Livewire\Traits\RepeatableFields;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Medical extends Component
{

    use RepeatableFields, WithFileUploads, WithAlert;

    public $user;
    
    public $photos = [];

    public $medical_folder = [];

    public function mount()
    {
        $this->user = backpack_user()->withFakes();

        $this->medical_folder = json_decode($this->user->medical_folder, true) ?? [];

    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:2048',
        ]);
    }

    function rules() {
        return [
            'medical_folder.*.photo' => 'required',
            'medical_folder.*.title' => 'required|string',
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('update-components');
        $this->dehydrateWithAlert();
    }

    public function submit()
    {
        // upload photo
        foreach($this->photos as $key => $photo) {
            if(is_object($photo)) {
                $resource = "/livewire/preview-file/{$photo->getFilename()}";
                $destination = '/uploads/images/user/medical_folder/'.$photo->getFilename();
                if(Storage::disk('local')->exists($resource)) Storage::disk('local')->copy($resource, $destination);
                $this->medical_folder[$key]['photo'] = $destination;
            }            
        }
        $this->photos = [];

        $this->validate();

        // $this->photo = null;
        // dd($this->new_services);
        $this->user->update([
            'extras->medical_folder' => json_encode($this->medical_folder),
        ]);

        Alert::success('تغییرات ذخیره شد')->flash();       
    }
    
    public function medical_folder()
    {
        return [
            // 'photo' => null,
            'title' => '',
            'description' => '',
        ];
    }   

    public function render()
    {
        return view('theme::modules.profile.medical')->layout('theme::modules.profile.layouts.profile');
    }
}
