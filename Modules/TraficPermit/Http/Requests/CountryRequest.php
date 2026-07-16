<?php

namespace Modules\TraficPermit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class CountryRequest extends FormRequest
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

        if(Request::get('status')) {
            return [
                'fa_name' => 'required|min:2|max:255',
                'en_name' => 'required|min:2|max:255',
                'amount' => 'integer|nullable',
                // 'types' => 'required',
                // 'image' => 'required',
            ];
        } else {
            return [
                'fa_name' => 'required|min:3|max:255',
                'en_name' => 'required|min:3|max:255',
                'amount' => 'integer|nullable',
            ];
        }

    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // 'types' => 'نوع مجوز',
            'image' => 'تصویر کشور',
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
