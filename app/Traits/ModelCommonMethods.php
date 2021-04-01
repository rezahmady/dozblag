<?php

namespace App\Traits;

trait ModelCommonMethods
{

    public function date($format = '%d %B %Y')
    {
        $v = verta($this->created_at);
        return $v->format($format);
    }

}