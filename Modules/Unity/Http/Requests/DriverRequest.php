<?php

namespace Modules\Unity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class DriverRequest extends FormRequest
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
            'fa_name' => 'required|min:5|max:255|persian_alpha',
            'en_name' => 'required|min:5|max:255|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/',
            'national_id' => 'required|ir_national_code|unique:drivers,national_id,'.Request::get('id'),
            'mobile' => 'required|string',
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
            'fa_name' =>  trans('unity::unity.fa_name'),
            'en_name' => trans('unity::unity.en_name'),
            'national_id' => trans('unity::unity.driver_national_id'),
            // 'mobile' =>  trans('unity::unity.unity_singular'),
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
