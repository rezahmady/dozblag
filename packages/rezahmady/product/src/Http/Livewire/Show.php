<?php

namespace Rezahmady\Product\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public Product $product;

    public $image;

    public $video;

    protected $queryString = ['video'];

    public function mount()
    {
        foreach($this->product->extras as $key => $item) {
            $this->product->{$key} = json_decode($item);
        }
        
        $this->image = asset($this->product->image);
    }

    protected $listeners = ['initVideo' => 'initVideo'];

    public function initVideo($video)
    {
        $this->video = $video;
        foreach($this->product->extras as $key => $item) {
            $this->product->{$key} = json_decode($item);
        }
        
        $this->image = asset('/uploads/images/product/'.$this->product->image);

        // $this->dispatchBrowserEvent('video-inited', ['video' => $video]);
        $this->emit('urlChanged', ['video' => $video]);

    }

    public function render()
    {
        return view('theme::modules.product.show')->layout('theme::layouts.app');
    }
}
