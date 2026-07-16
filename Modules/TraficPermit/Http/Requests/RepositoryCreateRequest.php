<?php

namespace Modules\TraficPermit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Modules\TraficPermit\Models\TraficPermit;
use Modules\TraficPermit\Models\TraficPermitType;

class RepositoryCreateRequest extends FormRequest
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
        $types = json_decode(Request::get('types'), false) ?? [];
        $invers_type = TraficPermitType::whereNotIN('id', $types)->pluck('id')->toArray();
        $country_id = Request::get('country_id');
        $year = Request::get('year') ?? null;
        
        return [
            'country_id' => 'required|exists:countries,id',
            'start_serial_number' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($types, $invers_type, $country_id, $year) {
                    $unique = TraficPermit::where('serial_number', $value);
                    // ->where('repository_id', '!=', Request::get('id'));

                    // if match types
                    foreach($types as $type) {
                        $unique = $unique->WhereHas('types', function($query) use ($type) {
                            $query->where('trafic_permit_type_id', $type);
                        });
                    }

                    foreach($invers_type as $type) {
                        $unique = $unique->whereDoesntHave('types', function($query) use ($type) {
                            $query->where('trafic_permit_type_id', $type);
                        });
                    }


                    $unique = $unique->whereHas('repository', function($q) use($country_id, $year) {
                        return $q->where('country_id', $country_id)->where('year', $year);
                    })->count();
                    if ($unique) {
                        $fail('این شماره '.$this->attributes()[$attribute].' از قبل موجود است ');
                    }
                },
            ],
            'end_serial_number' => [
                (Request::get('qty') > 1) ? 'gt:start_serial_number' : '',
                (Request::get('qty') > 1) ? 'integer' : '',
                Rule::requiredIf(Request::get('qty') > 1),
                (Request::get('qty') > 1) ? function ($attribute, $value, $fail) use ($types, $invers_type, $country_id, $year) {
                    $unique = TraficPermit::where('serial_number', $value);
                    // ->where('repository_id', '!=', Request::get('id'));

                    // if match types
                    foreach($types as $type) {
                        $unique = $unique->WhereHas('types', function($query) use ($type) {
                            $query->where('trafic_permit_type_id', $type);
                        });
                    }

                    foreach($invers_type as $type) {
                        $unique = $unique->whereDoesntHave('types', function($query) use ($type) {
                            $query->where('trafic_permit_type_id', $type);
                        });
                    }

                    $unique = $unique->whereHas('repository', function($q) use($country_id, $year) {
                        return $q->where('country_id', $country_id)->where('year', $year);
                    })->count();
                    if ($unique) {
                        $fail('این شماره '.$this->attributes()[$attribute].' از قبل موجود است ');
                    }
                } : '',
            ],
            'year' => 'required|date',
            'end_date' => 'required|date',
            'types' => 'required',//|exists:trafic_permit_types,id',
            'traficPermitTemplate' => 'required|exists:trafic_permit_templates,id',
            'qty' => [
                'required',
                'integer',
                'in:'. ((int) Request::get('end_serial_number') - (int) Request::get('start_serial_number') + 1)
            ],
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
