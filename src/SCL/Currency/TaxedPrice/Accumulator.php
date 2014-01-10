<?php

namespace SCL\Currency\TaxedPrice;

use SCL\Currency\Currency;
use SCL\Currency\TaxedPrice;
use SCL\Currency\Money;
use SCL\Currency\Money\Accumulator as MoneyAccumulator;
use SCL\Currency\Exception\CurrencyMismatchException;

class Accumulator
{
    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var TaxedPrice[]
     */
    private $prices = array();

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function add(TaxedPrice $price)
    {
        if (!$this->currency->isEqualTo($price->getCurrency())) {
            throw new CurrencyMismatchException($price->getCurrency()->getCode());
        }

        $this->prices[] = $price;
    }

    /**
     * @return TaxedPrice
     */
    public function calculateTotal()
    {
        $amounts = new MoneyAccumulator($this->currency);
        $taxes   = new MoneyAccumulator($this->currency);

        foreach ($this->prices as $price) {
            $amounts->add($price->getAmount());
            $taxes->add($price->getTax());
        }

        return new TaxedPrice(
            $amounts->calculateTotal(),
            $taxes->calculateTotal()
        );
    }
}
