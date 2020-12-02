<?php


namespace App;

use DateTime;

class Util
{

    public static function numberFormat($number)
    {
        if ($number != 0)
            $number = number_format($number, 0, ',', ' ');

        return $number;
    }

    public static function createIdNumber(string $type)
    {
        return $type.(new DateTime())->format("YmdHisv");
    }

}
