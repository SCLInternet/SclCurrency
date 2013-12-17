<?php

namespace SCL\Currency\Money;

use SCL\Currency\Currency;

interface Factory
{
    /**
     * @param float    $amount
     * @param Currency $currency
     *
     * @return Money
     */
    public function createWithCurrency($amount, Currency $currency);

    /**
     * @param float  $amount
     * @param string $code   3 letter currency code.
     *
     * @return Money
     */
    public function createWithCurrencyCode($amount, $code);

    /**
     * @param float $amount
     *
     * @return Money
     */
    public function createWithDefaultCurrency($amount);

    public function setDefaultCurrency(Currency $currency);
}
