<?php

namespace Modules\Unity\Enums;

enum DriverContractStatus:string {
    case Pending  = 'pending';
    case Active   = 'active';
    case Expired = 'expired';
    case Rejected = 'rejected';

    public static function get_translated_array()
    {
        $array = [];
        foreach(DriverContractStatus::cases() as $enum) {
            $array[$enum->value] = trans('unity::unity.status.'.$enum->value);
        }
        return $array;
    }
}
