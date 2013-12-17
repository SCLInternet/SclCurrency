<?php

namespace SCL\Currency;

use SCL\Currency\Exception\CurrencyMismatchException;
use SCL\Currency\Money\Calculator as MoneyCalculator;

class TaxedPrice
{
    /**
     * @var Money
     */
    private $amount;

    /**
     * @var Money
     */
    private $tax;

    /**
     * @throws CurrencyMismatchException
     */
    public function __construct(Money $amount, Money $tax)
    {
        if (!$amount->isSameCurrency($tax->getCurrency())) {
            throw new CurrencyMismatchException();
        }

        $this->amount = $amount;
        $this->tax    = $tax;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function getTotal()
    {
        return $this->getCalculator()->add($this->amount, $this->tax);
    }

    protected function getCalculator()
    {
        static $calc;

        if (null === $calc) {
            $calc = new MoneyCalculator();
        }

        return $calc;
    }
}
