<?php

namespace Rezahmady\Page\Http\Livewire;

use App\Http\Livewire\Traits\WithAlert;
use Rezahmady\Page\Models\Page as ModelsPage;
use Livewire\WithPagination;
use Livewire\Component;

class PageRender extends Component
{
    use WithPagination, WithAlert;

    // public $search;

    public ModelsPage $modelPage;
    protected $pagedata = [];

    public function register()
    {
        $this->modelPage = $this->modelPage->withFakes();

        $this->pagedata['title'] = $this->modelPage->title;
        $this->pagedata['entity'] = $this->modelPage->withFakes();
        // items
        $items = $this->modelPage->itemInChildren();
        $items = collect($items);
        $tags = [];
        if($this->modelPage->template == 'blog')
        {
            foreach ($items as $item) {
                $tags = array_merge($tags, $item->tags->toArray());
                if(sizeof($tags) >= 15) break;
            }
        }
        $this->pagedata['tags'] = $tags;
        // dd($this->pagedata['entity']);
        // if($this->search !== null and $this->search !== '') {
        //     $items = $items->where('name', 'LIKE', '%'.$this->search.'%');
        // }
        $max_item = $this->modelPage->max_item ?? 12;
        // ddd($items->where('name', 'like', '%'.$this->search.'%'));
        $this->pagedata['items'] = $items->sortBy('created_at', false, true)->paginate($max_item);
        // children
        $this->pagedata['children'] = $this->modelPage->children()->orderBy('lft')->paginate($this->modelPage->max_item);

        $this->pagedata['form'] = $this->pagedata['entity']['form'];
        
        return $this->pagedata;

    }

    public function mount()
    {
        $this->register();
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }
    
    public function render()
    {
        
        $pagedata = $this->register();
        $filename = ($this->modelPage->filename) ? $this->modelPage->filename : 'default';
        if (!$this->modelPage)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }
        return view('theme::modules.pages.'.$this->modelPage->template.'.'.$filename, $pagedata)->layout('theme::layouts.app');
    }
}
