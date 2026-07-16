<?php

namespace Modules\TraficPermit\Enums;

enum PermitOrderStatus:string {
    case Pending   = 'pending';
    case Issuing  = 'issuing';
    case Completed = 'completed';
    case Reject = 'reject';
    case Expired  = 'expired';

    public static function get_translated_array()
    {
        $array = [];
        foreach(PermitOrderStatus::cases() as $enum) {
            $array[$enum->value] = trans('traficpermit::traficpermit.order_status.'.$enum->value);
        }
        return $array;
    }
}

