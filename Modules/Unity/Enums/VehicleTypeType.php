<?php

namespace Modules\Unity\Enums;

enum VehicleTypeType:string {
    case Trailer = 'trailer';
    case Truck   = 'truck';

    public static function get_translated_array()
    {
        $array = [];
        foreach(VehicleTypeType::cases() as $enum) {
            $array[$enum->value] = trans('unity::unity.vehicletype.type.'.$enum->value);
        }
        return $array;
    }
}

