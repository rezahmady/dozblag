<?php

namespace Modules\Unity\Enums;

enum TruckContractStatus:string {
    case Pending  = 'pending';
    case Active   = 'active';
    case Expired = 'expired';
    case Rejected = 'rejected';

    public static function get_translated_array()
    {
        $array = [];
        foreach(TruckContractStatus::cases() as $enum) {
            $array[$enum->value] = trans('unity::unity.status.'.$enum->value);
        }
        return $array;
    }
}
