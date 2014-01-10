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
        $moneyFactory = MoneyFactory::createDefaultInstance();

        return new self($moneyFactory);
    }

    public function __construct(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    /*
     * @return TaxedPrice
     */
    public function createFromMoney(Money $amount, Money $taxAmount)
    {
        return new TaxedPrice($amount, $taxAmount);
    }

    /**
     * @param int $amount
     * @param int $taxAmount
     *
     * @return TaxedPrice
     */
    public function createFromUnits($amount, $taxAmount)
    {
        return new TaxedPrice(
            $this->moneyFactory->createFromUnits($amount),
            $this->moneyFactory->createFromUnits($taxAmount)
        );
    }

    /**
     * @param float $amount
     * @param float $tax
     *
     * @return TaxedPrice
     */
    public function createFromValues($amount, $taxAmount)
    {
        return new TaxedPrice(
            $this->moneyFactory->createFromValue($amount),
            $this->moneyFactory->createFromValue($taxAmount)
        );
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

    /**
     * @return Currency
     */
    public function getDefaultCurrency()
    {
        return $this->moneyFactory->getDefaultCurrency();
    }
}
