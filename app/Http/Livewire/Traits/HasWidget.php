<?php
namespace App\Http\Livewire\Traits;
use Alert;
use Rezahmady\SettingOperation\Setting;

trait HasWidget {

    public $widget;

    public $editable;

    public function getListeners()
    {
        return $this->listeners + [
            'update-widget' => 'widgetUpdate',
        ];
    }

    public function mountHasWidget()
    {
        $this->editable = Setting::get('themes.editable', true);
    }

    public function widgetUpdate()
    {
        $this->emit("widget-updated:{$this->widget}");
    }

    public function toggleEdite()
    {
        $status = (Setting::get('themes.editable') == true) ? false: true;
        $this->editable = $status;
        Setting::set('themes.editable', $status);
    }
}