<?php

namespace Modules\TraficPermit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TraficPermitTemplateRequest extends FormRequest
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
        return [
            'title' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            // 'types' => 'required',//|exists:trafic_permit_types,id',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'country_id' => trans('traficpermit::traficpermit.country_singular'),
            // 'types' => trans('traficpermit::traficpermit.trafic_permit_type_singular'),
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
