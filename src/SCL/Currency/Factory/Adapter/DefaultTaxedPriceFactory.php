<?php

namespace SCL\Currency\Factory\Adapter;

use SCL\Currency\Money;
use SCL\Currency\TaxedPrice;
use SCL\Currency\Factory\TaxedPriceFactory;
use SCL\Currency\Factory\MoneyFactory;

class DefaultTaxedPriceFactory implements TaxedPriceFactory
{
    /**
     * @var MoneyFactory
     */
    private $moneyFactory;

    public function __construct(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    public function createWithObjects(Money $amount, Money $tax)
    {
        return new TaxedPrice($amount, $tax);
    }

    public function createWithValues($amount, $tax, $currency)
    {
        return new TaxedPrice(
            $this->moneyFactory->createWithCurrencyCode($amount, $currency),

            $this->moneyFactory->createWithCurrencyCode($tax, $currency)
        );
    }

    public function createWithValuesAndDefaultCurrency($amount, $tax)
    {
        return new TaxedPrice(
            $this->moneyFactory->createWithDefaultCurrency($amount),
            $this->moneyFactory->createWithDefaultCurrency($tax)
        );
    }
}
