<?php

namespace SCL\Currency;

class Money
{
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var int
     */
    protected $value = 0;

    /**
     * @param int      $value
     * @param Currency $precision
     */
    public function __construct($value, Currency $currency)
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException();
        }

        $this->value    = $value;
        $this->currency = $currency;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isSameCurrency(Currency $currency)
    {
        return $this->currency->getCode() === $currency->getCode();
    }
}
