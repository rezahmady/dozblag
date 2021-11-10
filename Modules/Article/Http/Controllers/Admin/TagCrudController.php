<?php

namespace Modules\Article\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Modules\Article\Http\Requests\TagRequest;

class TagCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    public function setup()
    {
        $this->crud->setModel("Modules\Article\Models\Tag");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/tag');
        $this->crud->setEntityNameStrings(trans('general.tag_singular'), trans('general.tag_plural'));
        // $this->crud->setFromDb();
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('validation.attributes.name')
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TagRequest::class);
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('validation.attributes.name'),
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'عنوان تگ را اینجا بنویسید',
                'class'       => 'form-control form-control-lg'
            ],
            'prefix' => '<i class="la la-pencil la-lg"></i>'
        ]);


        $this->crud->addField([ // Text
            'name'  => 'slug',
            'label' => 'آدرس صفحه',
            'type'  => 'text',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'hint'  => 'درصورت خالی گذاشتن به طور خودکار از روی عنوان پست ساخته می شود',
        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(TagRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => trans('validation.attributes.name'),
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'عنوان تگ را اینجا بنویسید',
                'class'       => 'form-control form-control-lg'
            ],
            'prefix' => '<i class="la la-pencil la-lg"></i>'
        ]);


        $this->crud->addField([ // Text
            'name'  => 'slug',
            'label' => 'آدرس صفحه',
            'type'  => 'text',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'hint'  => 'درصورت خالی گذاشتن به طور خودکار از روی عنوان پست ساخته می شود',
        ]);
    }
}
