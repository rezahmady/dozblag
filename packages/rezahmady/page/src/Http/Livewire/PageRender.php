<?php

namespace Rezahmady\Page\Http\Livewire;

use App\Http\Livewire\Traits\WithAlert;
use Rezahmady\Page\Models\Page as ModelsPage;
use Livewire\WithPagination;
use Livewire\Component;
use Rezahmady\Article\Models\Article;
use TorMorten\Eventy\Facades\Events as Eventy;

class PageRender extends Component
{
    use WithPagination, WithAlert;

    // public $search;

    public ModelsPage $modelPage;
    protected $data = [];

    public function register()
    {
        $this->modelPage = $this->modelPage->withFakes();
        
        $this->data['title'] = $this->modelPage->title;
        $this->data['entity'] = $this->modelPage->withFakes();
        // items
        $items = $this->modelPage->itemInChildren();

        // dd( $this->modelPage);

        $items = Eventy::filter('page-renderpage-items', ['items' => $items,'page' => $this->modelPage]);
        
        $tags = [];
        if($this->modelPage->template == 'blog')
        {
            foreach ($items as $item) {
                $tags = array_merge($tags, $item->tags->toArray());
                if(sizeof($tags) >= 15) break;
            }
        }
        $this->data['tags'] = $tags;
        // dd($this->data['entity']);
        // if($this->search !== null and $this->search !== '') {
        //     $items = $items->where('name', 'LIKE', '%'.$this->search.'%');
        // }
        $max_item = $this->modelPage->max_item ?? 12;
        // ddd($items->where('name', 'like', '%'.$this->search.'%'));
        $this->data['items'] = $items->sortBy('created_at', false, true)->paginate($max_item);
        // children
        $this->data['children'] = $this->modelPage->children()->orderBy('lft')->paginate($this->modelPage->max_item);

        $this->data['form'] = $this->data['entity']['form'];
    }

    public function mount()
    {
        $this->register();
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function updatedPage($value)
    {
        $this->dispatchBrowserEvent('updated-components');
    }

    public function hydratePage($value)
    {
        $this->dispatchBrowserEvent('dehydrate-components');
    }

    
    public function render()
    {
        
        $this->register();
        $filename = ($this->modelPage->filename) ? $this->modelPage->filename : 'default';
        if (!$this->modelPage)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }
        // dd($this->data);
        return view('theme::modules.pages.'.$this->modelPage->template.'.'.$filename, $this->data)->layout('theme::layouts.app');
    }
}
