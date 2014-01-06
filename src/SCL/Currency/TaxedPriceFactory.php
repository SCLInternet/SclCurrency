<?php

namespace SCL\Currency;

use SCL\Currency\Factory\AbstractFactoryFacade;

class TaxedPriceFactory
{
    /**
     * @var MoneyFactory
     */
    private $moneyFactory;

    /**
     * @return TaxedPriceFactory
     */
    public static function createDefaultInstance()
    {
        return new self(MoneyFactory::createDefaultInstance());
    }

    public function __construct(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    /*
     * @return TaxedPrice
     */
    public function createFromMoney(Money $amount, Money $tax)
    {
        return new TaxedPrice($amount, $tax);
    }

    /**
     * @param int   $units
     * @param float $rate
     *
     * @return TaxedPrice
     */
    public function createFromUnitsAndRate($units, $rate)
    {
        $amount = $this->moneyFactory->createFromUnits($units);

        $taxCalc = new TaxedPrice\Calculator();

        $taxAmount = $taxCalc->calculateTaxAmount($amount, new TaxRate($rate));

        return $this->createFromMoney($amount, $taxAmount);
    }
}
