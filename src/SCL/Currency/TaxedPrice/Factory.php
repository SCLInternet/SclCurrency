<?php

namespace SCL\Currency\TaxedPrice;

use SCL\Currency\Money;
use SCL\Currency\TaxedPrice;

interface Factory
{
    /**
     * @return TaxedPrice
     */
    public function createWithObjects(Money $amount, Money $tax);

    /**
     * @param float  $amount
     * @param float  $tax
     * @param string $currency
     *
     * @return TaxedPrice
     */
    public function createWithValues($amount, $tax, $currency);

    /**
     * @param float $amount
     * @param float $tax
     *
     * @return TaxedPrice
     */
    public function createWithValuesAndDefaultCurrency($amount, $tax);
}
