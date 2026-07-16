<?php

namespace Modules\Unity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverContractRequest extends FormRequest
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
        $rules =  [
            'driver' => 'required|exists:drivers,id',
            'start_date' => 'required'
        ];

        if(backpack_user()->can('driver manage all')) {
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
            'unity' => trans('unity::unity.unity_singular'),
            'truck' => trans('unity::unity.truck_singular'),
            'start_date' => trans('unity::unity.start_date'),
            'end_date' => trans('unity::unity.end_date'),
            'driver' => trans('unity::unity.driver_singular'),
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
