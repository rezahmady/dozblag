<?php

namespace Rezahmady\Chat\Http\Controllers\Admin;

use Rezahmady\Chat\Http\Requests\RoomRequest;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Rezahmady\Chat\Events\ConsultationAdded;
use Rezahmady\Chat\Models\Room;
use Rezahmady\Subscribtion\Models\Subscribtion;
use Alert;
use App\Models\User;
use App\Notifications\Doctor\AsighnRoom;
use App\Notifications\Doctor\NewRoom as DoctorNewRoom;
use App\Notifications\Operator\NewRoom;

/**
 * Class RoomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoomCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use DefaultPermissions;
    Const ENTITY = 'chat';
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Room::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/room');
        CRUD::setEntityNameStrings('گفتگو', 'گفتگوها');

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                // any type of relationship
                'name'         => 'user', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'کاربر', // Table column heading
                // OPTIONAL
                // 'entity'    => 'tags', // the method that defines the relationship in your Model
                // 'attribute' => 'name', // foreign key attribute that is shown to user
                // 'model'     => App\Models\Category::class, // foreign key model
             ],
             [
                // any type of relationship
                'name'         => 'doctor', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'پزشک', // Table column heading
                // OPTIONAL
                // 'entity'    => 'tags', // the method that defines the relationship in your Model
                // 'attribute' => 'name', // foreign key attribute that is shown to user
                // 'model'     => App\Models\Category::class, // foreign key model
             ],
             [
                // any type of relationship
                'name'         => 'operator', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'اپراتور', // Table column heading
                // OPTIONAL
                // 'entity'    => 'tags', // the method that defines the relationship in your Model
                // 'attribute' => 'name', // foreign key attribute that is shown to user
                // 'model'     => App\Models\Category::class, // foreign key model
             ]
        ]);

        
        $this->crud->addButtonFromModelFunction('line', 'reset', 'resetRoom', 'beginning');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RoomRequest::class);

        CRUD::addFields([
            [   // 1-n relationship
                'label'       => "کاربر", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'user_id', // the column that contains the ID of that connected entity
                'entity'      => 'user', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/users"), // url to controller search function (with /{id} should return model)

                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "App\Models\User", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // 1-n relationship
                'label'       => "پزشک", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'doctor_id', // the column that contains the ID of that connected entity
                'entity'      => 'doctor', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/doctors"), // url to controller search function (with /{id} should return model)

                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "App\Models\User", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // 1-n relationship
                'label'       => "اپراتور", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'operator_id', // the column that contains the ID of that connected entity
                'entity'      => 'operator', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/operators"), // url to controller search function (with /{id} should return model)

                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "App\Models\User", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // 1-n relationship
                'label'       => "اشتراک", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'subscribtion_id', // the column that contains the ID of that connected entity
                'entity'      => 'subscribtion', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/subscribtion"), // url to controller search function (with /{id} should return model)
                'fake'        => true,
                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "Rezahmady\Subscribtion\Models\subscribtion", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [
                'name'       => 'remaining_duration',
                'type'       => 'number',
                'prefix'       => '<i class="la la-clock"></i>',
                'label'      => 'محدودیت زمانی',
                'suffix'     => 'دقیقه',
                'fake'       => true,
                'wrapper'    => [
                    'class'  => 'col-md-6'
                ]
            ],
            [
                'name'       => 'expire_date',
                'type'       => 'hidden',
                'fake'       => true,
                'value'      => null
            ]

        ]);

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
        CRUD::setValidation(RoomRequest::class);

        CRUD::addFields([
            [   // 1-n relationship
                'label'       => "کاربر", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'user_id', // the column that contains the ID of that connected entity
                'entity'      => 'user', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/users"), // url to controller search function (with /{id} should return model)

                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "App\Models\User", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // 1-n relationship
                'label'       => "پزشک", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'doctor_id', // the column that contains the ID of that connected entity
                'entity'      => 'doctor', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/doctors"), // url to controller search function (with /{id} should return model)

                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "App\Models\User", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // 1-n relationship
                'label'       => "اپراتور", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'operator_id', // the column that contains the ID of that connected entity
                'entity'      => 'operator', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/operators"), // url to controller search function (with /{id} should return model)

                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "App\Models\User", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // 1-n relationship
                'label'       => "اشتراک", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'subscribtion_id', // the column that contains the ID of that connected entity
                'entity'      => 'subscribtion', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/subscribtion"), // url to controller search function (with /{id} should return model)
                'fake'        => true,
                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                'model'                   => "Rezahmady\Subscribtion\Models\subscribtion", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [
                'name'       => 'remaining_duration',
                'type'       => 'number',
                'prefix'       => '<i class="la la-clock"></i>',
                'label'      => 'محدودیت زمانی',
                'suffix'     => 'دقیقه',
                'fake'       => true,
                'wrapper'    => [
                    'class'  => 'col-md-6'
                ]
            ],
            [
                'name'       => 'expire_date',
                'type'       => 'hidden',
                'fake'       => true,
                'value'      => $this->crud->getCurrentEntry()->expire_date
            ]

        ]);

        $this->crud->addSaveAction([
            'name' => 'save_action_and_reset',
            'redirect' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // what's the redirect URL, where the user will be taken after saving?
        
            // OPTIONAL:
            'button_text' => 'ذخیره و تمدید', // override text appearing on the button
            // You can also provide translatable texts, for example:
            // 'button_text' => trans('backpack::crud.save_action_one'),
            'visible' => function($crud) {
                return true;
            }, // customize when this save action is visible for the current operation
            'referrer_url' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // override http_referrer_url
            'order' => 1, // change the order save actions are in
        ]);
    }

    public function store()
    {
        $subscribtion = Subscribtion::find($this->crud->getRequest()->subscribtion_id);
        
        if ($this->crud->getRequest()->remaining_duration == null) {
            $this->crud->getRequest()->request->remove('remaining_duration');
            $this->crud->getRequest()->request->add(['remaining_duration'=> $subscribtion->extras->limit_duration]);
        }

        $response = $this->traitStore();
        $id = $this->crud->getCurrentEntry()->id;

        $room = Room::find($id);

        event(new ConsultationAdded($room));
        
        broadcast(new ConsultationAdded($room))->toOthers();

        // operator
        User::where('template', 'operator')->where('extras->telegram_user_id', '!=', null)->get()->each(function($user) use($room) {
            try {
                $user->notify(new NewRoom($room));
            } catch (\Throwable $th) {
                //throw $th;
            }
        });

        // doctor
        $doctor = User::where('id', session()->get('doctor_id'))->where('extras->telegram_user_id', '!=', null)->first();
        if($doctor)
        {
            try {
                $doctor->notify(new DoctorNewRoom($room));
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        return $response;
    }


    public function update()
    {
        $subscribtion = Subscribtion::find($this->crud->getRequest()->subscribtion_id);

        // notify doctor
        if((int) $this->crud->entry->doctor_id !== (int) $this->crud->getRequest()->doctor_id) {
            // doctor
            $doctor = User::where('id', $this->crud->getRequest()->doctor_id)->where('extras->telegram_user_id', '!=', null)->first();
            if($doctor)
            {
                try {
                    $doctor->notify(new AsighnRoom(Room::find($this->crud->entry->id)));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
        
        if ($subscribtion and $this->crud->getRequest()->remaining_duration == null) {
            $this->crud->getRequest()->request->remove('remaining_duration');
            $this->crud->getRequest()->request->add(['remaining_duration'=> $subscribtion->extras->limit_duration]);
        }
        
        if($this->crud->getRequest()->save_action === "save_action_and_reset") {
            $this->crud->getRequest()->request->add(['expire_date'=> null]);
            $this->crud->getRequest()->request->remove('operation_id');
            $this->crud->getRequest()->request->add(['operation_id'=> null]);
        }
        $response = $this->traitUpdate();
        return $response;
    }

    public function resetRoom(Room $room)
    {
        $room->update([
            'extras->expire_date' => null,
            'operation_id' => null,
            'extras->remaining_duration' => $room->subscribtion->extras->limit_duration
        ]);
        Alert::success("گفت‌و‌گو تمدید شد")->flash();
        return redirect()->to($this->crud->route);
    }
}
