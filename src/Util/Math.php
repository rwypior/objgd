<?php

namespace RWypior\Objgd\Util;

class Math
{
    public static function roundTo($n, $x)
    {
        return (round($n) % $x === 0) ? round($n) : round(($n + $x * 0.5) / $x) * $x;
    }

    public static function gcd($a, $b)
    {
        return $b ? self::gcd($b, $a % $b) : $a;
    }
}
