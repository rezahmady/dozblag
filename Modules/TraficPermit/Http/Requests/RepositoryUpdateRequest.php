<?php

namespace Modules\TraficPermit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Modules\TraficPermit\Models\TraficPermit;
use Modules\TraficPermit\Models\TraficPermitType;

class RepositoryUpdateRequest extends FormRequest
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
            'year' => 'required|date',
            'end_date' => 'required|date',
            'types' => 'required',
            'traficPermitTemplate' => 'required|exists:trafic_permit_templates,id',
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
            'qty' => trans('traficpermit::traficpermit.qty'),
            'start_serial_number' => trans('traficpermit::traficpermit.start_serial_number'),
            'end_serial_number' => trans('traficpermit::traficpermit.end_serial_number'),
            'year' => trans('traficpermit::traficpermit.year'),
            'end_date' => trans('traficpermit::traficpermit.end_date'),
            'types' => trans('traficpermit::traficpermit.trafic_permit_template_singular'),
            'traficPermitType' => trans('traficpermit::traficpermit.trafic_permit_type_singular'),
            'traficPermitTemplate' => trans('traficpermit::traficpermit.trafic_permit_template_singular'),
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
