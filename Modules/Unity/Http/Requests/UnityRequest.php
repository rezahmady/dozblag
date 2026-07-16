<?php

namespace Modules\Unity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UnityRequest extends FormRequest
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
            'fa_name' => 'required|unique:unities,fa_name,'.Request::get('id'),
            'en_name' => 'required|unique:unities,en_name,'.Request::get('id'),
            'national_id' => 'required|integer|unique:unities,national_id,'.Request::get('id'),
            'en_address' => 'required',
            'fa_address' => 'required',
            // 'shahrestan_id' => 'required',
            // 'ostan_id' => 'required',
            // 'registration_number' => 'required',
            // 'registration_date' => 'required',
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
            'en_name' => 'نام انگلیسی',
            'fa_name' => 'نام فارسی',
            'fa_address' => 'آدرس فارسی',
            'en_address' => 'آدرس انگلیسی',
            'national_id' => 'شناسه ملی',
            'shahrestan_id' => 'شهر',
            'ostan_id' => 'استان',
            'registration_number' => 'شماره ثبت',
            'registration_date' => 'تاریخ ثبت',
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
