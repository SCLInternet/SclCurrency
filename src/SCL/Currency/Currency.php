<?php

namespace SCL\Currency;

use SCL\Currency\Money\NumberScaler;

class Currency
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $precision;

    /**
     * @var NumberScaler
     */
    private $scaler;

    /**
     * @param string $code
     * @param in     $precision
     */
    public function __construct($code, $precision)
    {
        $this->code      = (string) $code;
        $this->precision = (int) $precision;
        $this->scaler    = new NumberScaler($this->precision);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param float $value
     *
     * @return int
     */
    public function removePrecision($value)
    {
        return $this->scaler->removePrecision($value);
    }

    /**
     * @param int $value
     *
     * @return float
     */
    public function addPrecision($value)
    {
        return $this->scaler->addPrecision($value);
    }
}
