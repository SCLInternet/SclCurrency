<?php

namespace SCL\Currency\Money;

use SCL\Currency\Exception\NegativePrecisionException;

class NumberScaler
{
    private $multiplier;

    /**
     * @param int $precision
     */
    public function __construct($precision)
    {
        $precision = (int) $precision;

        if ($precision < 0) {
            throw new NegativePrecisionException();
        }

        $this->multiplier = pow(10, $precision);
    }

    /**
     * @param int $number
     *
     * @return float
     */
    public function addPrecision($number)
    {
        return floatval($number / $this->multiplier);
    }

    /**
     * @param float $number
     *
     * @return int
     */
    public function removePrecision($number)
    {
        return intval($number * $this->multiplier);
    }
}
