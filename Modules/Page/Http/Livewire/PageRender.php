<?php

namespace Modules\Page\Http\Livewire;

use App\Http\Livewire\Traits\HasWidget;
use App\Http\Livewire\Traits\WithAlert;
use Modules\Page\Models\Page as ModelsPage;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class PageRender extends Component
{
    use WithPagination, WithAlert, HasWidget;

    public ModelsPage $modelPage;
    protected $data = [];
    public $perPage;
    public $max_item;

    public function register()
    {
        $this->modelPage = $this->modelPage->withFakes();
        $this->data['title'] = $this->modelPage->title;
        $this->data['entity'] = $this->modelPage->withFakes();
        $this->data['children'] = $this->modelPage->children()->orderBy('lft')->paginate($this->modelPage->max_item);
        $this->data['form'] = $this->data['entity']['form'];
    }

    public function items($method)
    {
        $model = app(get_class($this->modelPage->{$method}()->getRelated()));
        $pages_id = $this->modelPage->getAllChildsId();
        return $model->whereHas('pages', function (Builder $query) use($pages_id) {
            $query->whereIn('page_id', $pages_id);
        })->orderBy('updated_at', 'asc')->paginate($this->perPage);
    }

    public function mount()
    {
        $this->perPage = $this->max_item = $this->modelPage->max_item ?? 12;
        $this->register();
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
        $this->dispatchBrowserEvent('dehydrate-components');
    }

    public function get_items($method)
    {
        return $this->modelPage->{$method};
    }
    
    public function nextpage()
    {
        $this->perPage += $this->max_item;
    }

    public function render()
    {

        $this->register();
        $filename = ($this->modelPage->filename) ? $this->modelPage->filename : 'default';
        if (!$this->modelPage)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }
        return view('theme::modules.pages.'.$this->modelPage->template.'.'.$filename, $this->data)->layout('theme::layouts.app');
    }
}
