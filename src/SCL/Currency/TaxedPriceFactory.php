<?php

namespace SCL\Currency;

use SCL\Currency\Factory\AbstractFactoryFacade;

class TaxedPriceFactory
{
    public function createFromMoney(Money $amount, Money $tax)
    {
        return new TaxedPrice($amount, $tax);
    }

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        return new self();
    }
}
