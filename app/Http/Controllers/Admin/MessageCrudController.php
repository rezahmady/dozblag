<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Rezahmady\Page\Models\Page;
use Alert;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MessageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }
    use \Rezahmady\SettingOperation\SettingOperation;

    public $id;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Message::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/message');
        CRUD::setEntityNameStrings('صندوق پیام', 'صندوق پیام ها');
    }

    /**
    * Define what happens when the Setting operation is loaded.
    * 
    * @see https://github.com/rezahmady/setting-operation
    * @return void
    */
    protected function setupSettingOperation()
    {
        $this->crud->addFields([
            [
                'name'    => 'telegram_api_token',
                'type'    => 'text',
                'label'   => 'توکن بات تلگرامی',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6 ltr'
                 ], 
                'tab'     => 'تلگرام',
            ],
            [
                'name'    => 'telegram_link',
                'type'    => 'text',
                'label'   => 'لینک بات',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6 ltr'
                 ], 
                'tab'     => 'تلگرام',
            ],
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */

        CRUD::addColumn([
            'name' => 'subject', 'label' => 'عنوان', 
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere('subject', 'like', '%'.$searchTerm.'%');
            }
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'وضعیت',
            'type' => 'model_function',
            'function_name' => 'getStatus'
        ]);

        CRUD::addColumn([
            'name' => 'type',
            'label' => 'نوع',
            'type' => 'model_function',
            'function_name' => 'getType'
        ]);

       

          $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت'
          ], [
            0 => 'خوانده نشده',
            1 => 'خوانده شده',
          ], function($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
          });
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MessageRequest::class);

        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function show($id)
    {
        // custom logic before
        $content = $this->traitShow($id);
        // cutom logic after
        $message = $this->data['entry'];
        $message->status = 1;
        $message->save();
        // ddd($message);
        return $content;
    }

   

    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation 
        $this->crud->set('show.setFromDb', false);

        $this->crud->addButtonFromModelFunction('line', 'status', 'setStatusFalse', 'beginning');
        
        $message = $this->crud->getCurrentEntry();
        
        
        CRUD::addColumn([
            'name' => 'subject',
            'label' => 'عنوان'
        ]);

        CRUD::addColumn([
            'name' => 'type',
            'label' => 'نوع',
            'type' => 'model_function',
            'function_name' => 'getType'
        ]);

        if($message->form_id) {
            $values = json_decode($message->extras, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)['fields'];
            $page = Page::find($message->form_id);
            $form = json_decode($page->extras['form'], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            $fields = $form['fields'];
            // ddd($values);
            // ddd($fields);
            foreach ($fields as $key => $field) {
                if($field['tag'] == 'textarea') {
                    $this->crud->addColumn([
                        'name' => $field['id'],
                        'label' => $field['config']['label'],
                        'type'     => 'closure',
                        'function' => function($entry) use ($values, $key) {
                            return $values[$key];
                        }
                    ]);
                }
                if($field['tag'] == 'input') {
                    if(isset($field['attrs']['type']) and $field['attrs']['type'] == 'radio' and isset($values[$key])) {
                        $this->crud->addColumn([
                            'name' => $field['id'],
                            'label' => $field['config']['label'],
                            'type'     => 'closure',
                            'function' => function($entry) use ($values, $key, $field) {
                                $found_key = array_search($values[$key], array_column($field['options'], 'value'));
                                return $field['options'][$found_key]['label'];
                            }
                        ]);
                    }
                    elseif(isset($field['attrs']['type']) and $field['attrs']['type'] == 'checkbox') {
                        // $found_key = array_search($values[$key], array_column($field['options'], 'value'));
                        $this->crud->addColumn([
                            'name' => $field['id'],
                            'label' => $field['options'][0]['label'],
                            'type'     => 'closure',
                            'function' => function($entry) use ($values, $key) {
                                if(isset($values[$key])) {
                                    return '<i class=" la la-check-circle"></i>';
                                }
                                return '<i class=" la la-circle-o"></i>';
                            }
                        ]);
                    } elseif(isset($field['attrs']['type']) and $field['attrs']['type'] === 'file') {
                        $this->crud->addColumn([
                            'name' => $field['id'],
                            'label' => $field['config']['label'],
                            'type'     => 'closure',
                            'function' => function($entry) use ($values, $key) {
                                if(is_array(getimagesize(url($values[$key])))) {
                                    return "<img src='".url($values[$key])."' width='150px' />";
                                } else {
                                    return '<a href="'.url($values[$key]).'">دانلود <i class="la la-download"></i></a>';
                                }
                            }
                        ]);
                    } elseif(isset($values[$key])) {
                        $this->crud->addColumn([
                            'name' => $field['id'],
                            'label' => $field['config']['label'],
                            'type'     => 'closure',
                            'function' => function($entry) use ($values, $key) {
                                return $values[$key];
                            }
                        ]);
                    }
                }

                if($field['tag'] == 'select') {
                    $this->crud->addColumn([
                        'name' => $field['id'],
                        'label' => $field['config']['label'],
                        'type'     => 'closure',
                        'function' => function($entry) use ($values, $key, $field) {
                            $found_key = array_search($values[$key], array_column($field['options'], 'value'));
                            return $field['options'][$found_key]['label'];
                        }
                    ]);
                }
            }

        } else {
            $this->crud->addColumn([
                'name' => 'content',
                'label' => 'محتوا'
            ]);
        }
        // example logic

       

        // Note: if you HAVEN'T set show.setFromDb to false, the removeColumn() calls won't work
        // because setFromDb() is called AFTER setupShowOperation(); we know this is not intuitive at all
        // and we plan to change behaviour in the next version; see this Github issue for more details
        // https://github.com/Laravel-Backpack/CRUD/issues/3108
    }

    public function toggleSeen(Message $message)
    {
        $message->status = ! $message->status;
        $message->save();
        Alert::success("وضعیت پیام تغییر کرد")->flash();
        return redirect()->to($this->crud->route);
    }
}
