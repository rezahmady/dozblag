<?php

namespace Modules\User\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use TorMorten\Eventy\Facades\Events as Hook;

class UserUpdateCrudRequest extends FormRequest
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
        return Hook::filter('user-validate-update-attributes', []);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userModel = new User();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->get('id') ?? \Request::instance()->segment($routeSegmentWithId);

        if (!$userModel->find($userId)) {
            abort(400, 'Could not find that entry in the database.');
        }

        $rules = [
            'email'    => 'nullable|unique:'.config('permission.table_names.users', 'users').',email,'.$userId,
            'mobile'   => 'required|string|max:11|min:10|unique:'.config('permission.table_names.users', 'users').',mobile,'.$userId,
            'name'     => 'required',
            'password' => 'confirmed',
        ];


        return Hook::filter('user-validate-update-rules', $rules);
    }
}
