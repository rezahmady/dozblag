<?php

namespace Modules\TraficPermit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Truck;
use Rezahmady\SettingOperation\Setting;

class PermitOrderRequest extends FormRequest
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
            'destination' => 'required|exists:countries,id',
            'trailer' => [
                'required',
                'exists:trailers,id',
                (!backpack_user()->can('truck manage all')) ? function ($attribute, $value, $fail) {
                    $unique = Trailer::where('id', $value)
                        ->whereExists(function ($query) {
                            $query->select(DB::raw('*'))
                                ->from('permit_orders')
                                ->whereColumn('permit_orders.trailer_id', 'trailers.id')
                                ->where('permit_orders.id', '!=', Request::get('id'))
                                ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
                                ->where('permit_order_trafic_permit.status', 1)
                                ->where('permit_order_trafic_permit.get_carcasses_at', null);
                            // ->join('trafic_permits', 'trafic_permits.id', '=', 'permit_order_trafic_permit.trafic_permit_id')
                            // ->where('trafic_permits.status', 'issued');
                        })->count();

                    if ($unique) {
                        $fail('این یدک یک لاشه تحویل داده نشده دارد');
                    }
                } : '',
                (!backpack_user()->can('truck manage all')) ? function ($attribute, $value, $fail) {
                    $unique = Trailer::where('id', $value)
                        ->WhereExists(function ($query) {
                            //درخواست باز نداشته باشد
                            $query->select(DB::raw('*'))
                                ->from('permit_orders')
                                ->whereColumn('permit_orders.trailer_id', 'trailers.id')
                                ->where('permit_orders.id', '!=', Request::get('id'))
                                ->whereIn('permit_orders.status', ['pending', 'issuing'])
                                ->whereNull('permit_orders.deleted_at');
                        })->count();

                    if ($unique) {
                        $fail('این یدک یک درخواست باز دارد');
                    }
                } : '',
            ],
            'truck' => [
                'required',
                'exists:trucks,id',
                (!backpack_user()->can('truck manage all')) ? function ($attribute, $value, $fail) {
                    $unique = Truck::where('id', $value)
                    ->whereExists(function ($query) {
                        $query->select(DB::raw('*'))
                        ->from('permit_orders')
                        ->whereColumn('permit_orders.truck_id', 'trucks.id')
                            ->where('permit_orders.id', '!=', Request::get('id'))
                        ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
                        ->where('permit_order_trafic_permit.status', 1)
                        ->where('permit_order_trafic_permit.get_carcasses_at', null);
                        // ->join('trafic_permits', 'trafic_permits.id', '=', 'permit_order_trafic_permit.trafic_permit_id')
                        // ->where('trafic_permits.status', 'issued');
                    })->count();

                    if ($unique) {
                        $fail('این وسیله‌ی نقلیه یک لاشه تحویل داده نشده دارد');
                    }
                } : '',
                (!backpack_user()->can('truck manage all')) ? function ($attribute, $value, $fail) {
                    $unique = Truck::where('id', $value)
                    ->WhereExists(function ($query) {
                        //درخواست باز نداشته باشد
                        $query->select(DB::raw('*'))
                        ->from('permit_orders')
                        ->whereColumn('permit_orders.truck_id', 'trucks.id')
                            ->where('permit_orders.id', '!=', Request::get('id'))
                        ->whereIn('permit_orders.status', ['pending', 'issuing'])
                        ->whereNull('permit_orders.deleted_at');
                    })->count();

                    if ($unique) {
                        $fail('این وسیله‌ی نقلیه یک درخواست باز دارد');
                    }
                } : '',
            ],
            'driver' => [
                'required',
                'exists:drivers,id'
            ],
            'carnet_number' => 'required|regex:/^([a-zA-Z])\w{1}([0-9]){8}$/|unique:permit_orders,carnet_number,'.Request::get('id').',id,deleted_at,NULL',
            'carnet_date' => 'required',
            // 'en_driver_name' => 'required|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/',
            // 'en_driver_assitance' => 'nullable|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/',
            'orders' => 'required',
//            'photos.*' => [
//                'nullable',
//                'max:10048', // file size in KB
//                'mimetypes:image/jpeg,application/pdf', // allow only some mimetypes
//            ],

        ];


        if(backpack_user()->can('truck manage all')) {
            $rules = array_merge($rules, ['unity_id' => 'required|exists:unities,id'] );
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
            'destination' => trans('traficpermit::traficpermit.destination'),
            'en_driver_name' => trans('traficpermit::traficpermit.en_driver_name'),
            'en_driver_assitance' => trans('traficpermit::traficpermit.en_driver_assitance'),
            'driver' => 'راننده',
            'trailer' => trans('unity::unity.trailer_singular'),
            'carnet_number' => 'شماره کارنه',
            'carnet_date' => 'تاریخ صدور کارنه',
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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Only block new order creation; updates of existing orders are allowed.
            if (! $this->isMethod('post')) {
                return;
            }

            if ((string) Setting::get('trafic_permit_general.block_order_on_debt', '1') !== '1') {
                return;
            }

            if (backpack_user()->can('PermitOrder special') || backpack_user()->can('truck manage all')) {
                return;
            }

            $unity = backpack_user()->unity;

            if ($unity && $unity->cashed_balance < 0) {
                $validator->errors()->add(
                    'unity_id',
                    'به‌دلیل بدهی امکان ثبت درخواست وجود ندارد. لطفاً ابتدا بدهی را تسویه کنید.'
                );
            }
        });
    }
}
