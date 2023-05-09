<?php

namespace App\Helpers;

class Util
{
    public static function debitsSum($debits)
    {
        $sum = 0;

        foreach ($debits as $debit) {
            $sum += $debit->value;
        }

        return doubleval($sum);
    }
}
