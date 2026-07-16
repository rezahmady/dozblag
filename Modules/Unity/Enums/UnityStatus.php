<?php

namespace Modules\Unity\Enums;

enum UnityStatus:string {
    case Active   = 'active';
    case Inactive = 'inactive';

    public static function get_translated_array()
    {
        $array = [];
        foreach(UnityStatus::cases() as $enum) {
            $array[$enum->value] = trans('unity::unity.status.'.$enum->value);
        }
        return $array;
    }
}

