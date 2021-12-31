<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TorMorten\Eventy\Facades\Events as Hook;

class UserStoreCrudRequest extends FormRequest
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

    public function attributes()
    {
        return Hook::filter('user-validate-store-attributes', []);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'email'    => 'nullable|unique:'.config('permission.table_names.users', 'users').',email',
            'mobile'   => 'required|unique:'.config('permission.table_names.users', 'users').',mobile',
            'name'     => 'required',
            'password' => 'required|confirmed',
        ];

        return Hook::filter('user-validate-store-rules', $rules);
    }
}
