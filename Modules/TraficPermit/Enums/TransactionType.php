<?php

namespace Modules\TraficPermit\Enums;

enum TransactionType:string {
    case Deposit   = 'deposit';
    case Withdraw  = 'withdraw';

    public static function get_translated_array()
    {
        $array = [];
        foreach(TransactionType::cases() as $enum) {
            $array[$enum->value] = trans('traficpermit::traficpermit.transaction_types.'.$enum->value);
        }
        return $array;
    }
}

