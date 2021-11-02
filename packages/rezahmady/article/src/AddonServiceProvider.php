<?php

namespace Rezahmady\Article;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Article\Http\Livewire\ShareHolder;
use Rezahmady\Article\Http\Livewire\TagRender;
use Rezahmady\Article\Models\Article;
use TorMorten\Eventy\Facades\Events as Eventy;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'article';
    protected $commands = [];

    public function moduleBoot() : void
    {
        Livewire::component('article.share-holder', ShareHolder::class);
        Livewire::component('rezahmady.article.http.livewire.tag-render', TagRender::class);

        // hooks
        Eventy::addFilter('page-renderpage-items', function($argc) {
            $page = $argc['page'];
            $items = $argc['items'];
            if($page->slug == 'mag') {
                $uncategorizedArticles = Article::published()->whereDoesntHave('pages')->get();
                $items = collect($items);
                $items = $items->merge($uncategorizedArticles);
            }
            return collect($items);
        }, 20, 1);
    }

    public function menuBuilder($menu)
    {
        if(backpack_user()->can('post manage')) {
            $menu->add('articles', trans('rezahmady.article::article.article_menu_label') ,'#' , 400, 'newspaper-o');
            $menu->add('articles.list', trans('rezahmady.article::article.article_plural') , backpack_url('article') , 410, 'newspaper-o');
            $menu->add('articles.tag', trans('rezahmady.article::article.tag_plural') , backpack_url('tag') , 420, 'tag');
        }
    }
}
