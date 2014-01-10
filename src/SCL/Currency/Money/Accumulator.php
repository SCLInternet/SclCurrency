<?php

namespace SCL\Currency\Money;

use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\Exception\CurrencyMismatchException;

class Accumulator
{
    /**
     * @var Money[]
     */
    private $monies = array();

    /**
     * @var Currency
     */
    private $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function add(Money $amount)
    {
        if (!$amount->getCurrency()->isEqualTo($this->currency)) {
            throw new CurrencyMismatchException($amount->getCurrency()->getCode());
        }

        $this->monies[] = $amount;
    }

    /**
     * @return Money
     */
    public function calculateTotal()
    {
        return Money::createFromUnits($this->getTotalUnits(), $this->currency);
    }

    /**
     * @return int
     */
    private function getTotalUnits()
    {
        return array_reduce(
            $this->monies,
            function ($total, $money) {
                return $total + $money->getUnits();
            },
            0
        );
    }
}
