<?php

namespace Modules\TraficPermit\Enums;

enum PaperSize:string {
    case A4   = 'A4';
    case A5  = 'A5';

    public static function get_translated_array()
    {
        $array = [];
        foreach(PaperSize::cases() as $enum) {
            $array[$enum->value] = trans('traficpermit::traficpermit.paper_size.'.$enum->value);
        }
        return $array;
    }
}

