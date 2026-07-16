<?php

namespace Modules\Unity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

class TruckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            // truck
            'transit_number' => 'required|unique:trucks,transit_number,'.Request::get('id'),
            'vehicletype' => 'required|exists:vehicletypes,id',
            'iranian_plates_number' => 'required|nullable|string',
            'chassis_number' => 'nullable|unique:trucks,chassis_number,'.Request::get('id'),
            'engine_number' => 'nullable|unique:trucks,engine_number,'.Request::get('id'),
            'model' => 'integer',
            'trailer' => function($attribute, $value, $fail) {  
                $fieldGroups = json_decode($value);

                // allow repeatable field group to be empty
                if (count($fieldGroups) == 0) {
                  return true;
                }

                // run through each field group inside the repeatable field
                // and run a custom validation for it
                foreach ($fieldGroups as $key => $group) {
                    $fieldGroupValidator = Validator::make((array)$group, [
                        'transit_number' => 'required',
                        'vehicletype_id' => 'required|exists:vehicletypes,id',
                    ]);

                    $fieldGroupValidator->setAttributeNames($this->attributes()); 

                    if ($fieldGroupValidator->fails())
                    {
                        $error = trans('unity::unity.trailer').": ";
                        foreach($fieldGroupValidator->errors()->getMessages() as $field) {
                            foreach($field as $err) {
                                $error .= nl2br($err)." | ";
                            }
                        }
                        $fail($error);
                    }

                 }
            },
        ];

        if(backpack_user()->can('truck manage all')) {
            $rules = array_merge($rules, ['unity' => 'required|exists:unities,id'] );
        }

        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // truck
            'transit_number' => trans('unity::unity.transit_number'),
            'chassis_number' => trans('unity::unity.chassis_number'),
            'engine_number' => trans('unity::unity.engine_number'),
            'iranian_plates_number' => trans('unity::unity.iranian_plates_number'),
            'vehicletype_id' => trans('unity::unity.truck_type'),
            'vehicletype' => trans('unity::unity.truck_type'),
            // trailer
            'trailer_transit_number' => trans('unity::unity.validation_trailer_transit_number'),
            'trailer_chassis_number' => trans('unity::unity.validation_trailer_chassis_number'),
            'trailer_engine_number' => trans('unity::unity.validation_trailer_engine_number'),
            'trailer_vehicletype_id' => trans('unity::unity.trailer_type'),
            'trailer' => trans('unity::unity.trailer'),
            'model' => trans('unity::unity.model'),
            'unity' => trans('unity::unity.unity_singular'),
        ];
    }

}
