<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomRequest;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Events\ConsultationAdded;

/**
 * Class RoomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoomCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use DefaultPermissions;
    Const ENTITY = 'chat';
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Room::class);
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
             ],
        ]);

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
        $this->setupCreateOperation();
    }
    public function store()
    {
        // do something before validation, before save, before everything; for example:
        // $this->crud->addField(['type' => 'hidden', 'name' => 'author_id']);
    // $this->crud->removeField('password_confirmation');

    // Note: By default Backpack ONLY saves the inputs that were added on page using Backpack fields.
    // This is done by stripping the request of all inputs that do NOT match Backpack fields for this
    // particular operation. This is an added security layer, to protect your database from malicious
    // users who could theoretically add inputs using DeveloperTools or JavaScript. If you're not properly
    // using $guarded or $fillable on your model, malicious inputs could get you into trouble.

    // However, if you know you have proper $guarded or $fillable on your model, and you want to manipulate
    // the request directly to add or remove request parameters, you can also do that.
    // We have a config value you can set, either inside your operation in `config/backpack/crud.php` if
    // you want it to apply to all CRUDs, or inside a particular CrudController:
        // $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
    // The above will make Backpack store all inputs EXCEPT for the ones it uses for various features.
    // So you can manipulate the request and add any request variable you'd like.
    // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
    // $this->crud->getRequest()->request->remove('password_confirmation');

        $response = $this->traitStore();
        $id = $this->crud->getCurrentEntry()->id;
        event(new ConsultationAdded());

        return $response;
    }
}
