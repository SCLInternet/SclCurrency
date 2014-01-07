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

    public function add(Money $amount)
    {
        if (!$this->currency) {
            $this->currency = $amount->getCurrency();
        }

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
        // @todo This is bad! The currency returned should really be known.
        $currency = $this->currency ?: new Currency('GBP', 2);

        return Money::createFromUnits($this->getTotalUnits(), $currency);
    }

    /**
     * @return int
     */
    private function getTotalUnits()
    {
        return array_sum(array_map(
            function ($money) {
                return $money->getUnits();
            },
            $this->monies
        ));
    }
}
