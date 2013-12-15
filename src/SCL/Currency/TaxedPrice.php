<?php

namespace SCL\Currency;

class TaxedPrice
{
    /**
     * @var CurrencyValue
     */
    private $amount;

    /**
     * @var CurrencyValue
     */
    private $tax;

    public function __construct()
    {
        $this->amount = new CurrencyValue(0);
        $this->tax    = new CurrencyValue(0);
    }

    public function setAmount(CurrencyValue $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return CurrencyValue
     */
    public function getAmount()
    {
        return $this->amount;
    }

    public function setTax(CurrencyValue $tax)
    {
        $this->tax = $tax;
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
            $calc = new CurrencyCalculator();
        }

        return $calc;
    }
}
