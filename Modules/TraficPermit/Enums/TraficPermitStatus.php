<?php

namespace Modules\TraficPermit\Enums;

enum TraficPermitStatus:string {
    case Active          = 'active';
    case Issued          = 'issued';
    case Consumed        = 'consumed';
    case Inactive        = 'inactive';
    // failed
    case Expired         = 'expired';
    case Lost            = 'lost';
    case Deformation     = 'deformation';
    case Recursive       = 'recursive';

    public static function get_translated_array()
    {
        $array = [];
        foreach(TraficPermitStatus::cases() as $enum) {
            $array[$enum->value] = trans('traficpermit::traficpermit.status.'.$enum->value);
        }
        return $array;
    }
}

