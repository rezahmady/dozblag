<?php

namespace Modules\Unity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckContractRequest extends FormRequest
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
            'truck' => 'required|exists:trucks,id',
            'start_date' => 'required'
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
            'unity' => trans('unity::unity.unity_singular'),
            'truck' => trans('unity::unity.truck_singular'),
            'start_date' => trans('unity::unity.start_date'),
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
