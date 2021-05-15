<?php
namespace App\Http\Livewire\Traits;
use Alert;

trait WithAlert {
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess($message)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => $message]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($message)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'error',  'message' => $message]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($message)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'info',  'message' => $message]);
    }

    public function dehydrateWithAlert()
    {
        foreach (Alert::getMessages() as $type => $messages) {
            foreach ($messages as $message) {
                switch ($type) {
                    case 'success':
                        $this->alertSuccess($message);
                        break;
                    case 'error':
                        $this->alertError($message);
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
    }
}