<?php

namespace common\helper;

class NumberHelper
{
    const TINY_INT_SORT_ORDER_DEFAULT = 100;
    const SMALL_INT_SORT_ORDER_DEFAULT = 30000;

    public static function price_format($number) {
        return number_format($number, 2, '.', '');
    }
}
