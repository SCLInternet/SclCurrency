<?php

namespace SCL\Currency;

use SCL\Currency\Exception\IncorrectPrecisionException;
use SCL\Currency\Exception\NegativePrecisionException;

class CurrencyValue
{
    /**
     * @var int
     */
    protected $precision;

    /**
     * @var int
     */
    protected $value = 0;

    /**
     * @param  int $precision
     */
    public function __construct($precision = 2)
    {
        if (0 > $precision) {
            throw new NegativePrecisionException();
        }

        $this->precision = (int) $precision;
    }

    /**
     * @param  float $value
     * @param  int   $precision
     *
     * @return CurrencyValue
     */
    public static function createFromValue($value, $precision = 2)
    {
        $cv = new self($precision);

        $cv->setValue($value);

        return $cv;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->addPrecision($this->value);
    }

    /**
     * @param  float $value
     */
    public function setValue($value)
    {
        $this->ensurePrecision($value);

        $this->value = $this->stripPrecision($value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $format = '%.0' . $this->precision . 'f';

        return sprintf($format, $this->getValue());
    }

    /**
     * Check the value doesn't have a heigher precision than expected.
     *
     * @param  float $value
     */
    private function ensurePrecision($value)
    {
        $normalized = $this->addPrecision($this->stripPrecision($value));

        if ($value != $normalized) {
            throw new IncorrectPrecisionException();
        }
    }

    /**
     * @param  float $value
     *
     * @return int
     */
    private function stripPrecision($value)
    {
        return intval(round($value * pow(10, $this->precision)));
    }

    /**
     * @param  int $value
     *
     * @return float
     */
    private function addPrecision($value)
    {
        return floatval($value / pow(10, $this->precision));
    }
}
