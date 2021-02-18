<?php

namespace App\Traits;

trait UserTemplates
{
    /*
    |--------------------------------------------------------------------------
    | User Templates
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    */

    private function operator()
    {
        
    }

    private function doctor()
    {
        $this->crud->addField([
            'name'    => 'bio',
            'type'    => 'textarea',
            'label'   => 'درباره من',
            'tab'     => 'مشخصات فردی',
            'fake'  => true,
            'store_in' => 'extras',
        ],);
    }

    private function clinic()
    {

    }

    private function customer()
    {

    }
}