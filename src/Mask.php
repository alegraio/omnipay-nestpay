<?php

namespace Omnipay\NestPay;

class Mask
{
    /**
     * @param string $value
     * @param null $maskSymbol
     * @param int $showLast
     * @return string
     */
    public static function mask(string $value, $maskSymbol = null, $showLast = 3): string
    {
        $maskSymbol = $maskSymbol ?: 'X';
        $showLast = max(0, $showLast);

        if (false === $showLast || mb_strlen($value) <= ($showLast + 1) * 2) {
            $showRegExpPart = "";
        } else {
            $showRegExpPart = "(?!(.){0,$showLast}$)";
        }

        return preg_replace("/(?!^.?)[^-_\s]$showRegExpPart/u", $maskSymbol, $value);
    }
}