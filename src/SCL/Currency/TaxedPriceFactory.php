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

        $moneyFactory->setDefaultCurrency(
            CurrencyFactory::createDefaultInstance()->create('GBP')
        );

        return new self($moneyFactory);
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
     * @param float $amount
     * @param float $tax
     *
     * @return TaxedPrice
     */
    public function createFromValues($amount, $tax)
    {
        return new TaxedPrice(
            $this->moneyFactory->createFromValue($amount),
            $this->moneyFactory->createFromValue($tax)
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
