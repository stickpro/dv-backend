<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Services\Currency\Interfaces\CurrencyConversionInterface;
/**
 * CurrencyConversion
 */
class CurrencyConversion implements CurrencyConversionInterface
{
    /**
     * @param string $amount
     * @param string $rate
     * @param bool $reverseRate
     * @return string
     */
    public function convert(string $amount, string $rate, bool $reverseRate = false): string
    {
        if ($reverseRate) {
            $rate = bcdiv("1", $rate);
        }

        return bcmul($amount, $rate);
    }
}
