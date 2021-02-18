<?php
namespace App\Http\Livewire\Traits;

trait WidgetRender {
    
    public function renderWhen(): bool
    {
		if ($this->widget->status) {
			return true;
		}

        return false;
    }


    public function render()
    {
        if($this->renderWhen()) return view($this->view);
        return  '<div></div>';
    }
}