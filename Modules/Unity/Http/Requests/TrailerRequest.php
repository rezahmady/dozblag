<?php

namespace Modules\Unity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class TrailerRequest extends FormRequest
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
            'transit_number' => 'required|unique:trailers,transit_number,'.Request::get('id'),
            'vehicletype' => 'required|exists:vehicletypes,id',
        ];

        if(backpack_user()->can('Trailer manage all')) {
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

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
