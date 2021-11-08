<?php

namespace Rezahmady\Page;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Page\Http\Livewire\Widgets\ListGroup;
use Rezahmady\Page\Http\Livewire\Widgets\ListGrouped;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Rezahmady\Page\Models\Page;
use Rezahmady\Page\Http\Livewire\PageRender;
use TorMorten\Eventy\Facades\Eventy;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'page';
    protected $commands = [];

    public function moduleBoot() : void
    {
        
        Route::model('modelPage', Page::class);

        Livewire::component('widgets.page-group', ListGroup::class);
        Livewire::component('widgets.page-grouped', ListGrouped::class);
        Livewire::component('rezahmady.page.http.livewire.page-render', PageRender::class);

        Paginator::useBootstrap();

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Eventy::addAction('admin-menu-build', function($menu) { 
            if(backpack_user()->can('page list')){
            
                $menu->add('pages', trans('rezahmady.page::page.page_menu_title') , '#' , 500 , 'file');
                $menu->add('pages.list', trans('rezahmady.page::page.page_all') , backpack_url('page') , 510, 'file');
                if(backpack_user()->can('page create text'))
                    $menu->add('pages.text', trans('rezahmady.page::page.page_create_content') , backpack_url('page/create?template=text') , 520, 'align-right');
                if(backpack_user()->can('page create shop'))
                    $menu->add('pages.shop', trans('rezahmady.page::page.page_create_shop') , backpack_url('page/create?template=shop') , 530, 'shopping-cart');
                if(backpack_user()->can('page create blog'))
                    $menu->add('pages.blog', trans('rezahmady.page::page.page_create_blog') , backpack_url('page/create?template=blog') , 540, 'file-text');
                if(backpack_user()->can('page create gallery'))
                    $menu->add('pages.gallery', trans('rezahmady.page::page.page_create_gallery') , backpack_url('page/create?template=gallery') , 550, 'image');
                if(backpack_user()->can('page create form'))
                    $menu->add('pages.form', trans('rezahmady.page::page.page_create_form') , backpack_url('page/create?template=form') , 560, 'clipboard');
                if(backpack_user()->can('page create link'))
                    $menu->add('pages.link', trans('rezahmady.page::page.page_create_link') , backpack_url('page/create?template=link') , 570, 'link');
            } 
        }, 20, 1);
    }
}
