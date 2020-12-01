<?php


namespace App;

class Util
{

    public static function numberFormat($number)
    {
        if ($number != 0)
            $number = number_format($number, 0, ',', ' ');

        return $number;
    }

}
