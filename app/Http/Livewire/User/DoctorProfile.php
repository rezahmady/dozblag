<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

class DoctorProfile extends Component
{
    public $doctor;

    public $clinics;

    public $edu_bg;

    public $job_bg;

    public $gif_bg;

    public $services;

    public function mount(User $user) {
        
        $this->doctor = $user->withFakes();

        $this->clinics = json_decode($this->doctor->clinics);

        $this->edu_bg = json_decode($this->doctor->edu_bg);

        $this->job_bg = json_decode($this->doctor->job_bg);

        $this->gif_bg = json_decode($this->doctor->gif_bg);

        $this->services = json_decode($this->doctor->services);

        // ddd($this->doctor);

    }

    public function render()
    {
        return view('theme::modules.user.doctor-profile')->layout('theme::layouts.app');
    }
}
