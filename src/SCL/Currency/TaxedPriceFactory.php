<?php

namespace SCL\Currency;

use SCL\Currency\TaxedPrice\Factory;
use SCL\Currency\TaxedPrice\DefaultFactory;
use SCL\Currency\Factory\AbstractFactoryFacade;

class TaxedPriceFactory extends AbstractFactoryFacade
{
    /**
     * @param Money|float $amount
     * @param Money|float $tax
     * @param string      $currency
     *
     * @return TaxedPrice
     */
    public function create($amount, $tax, $currency = null)
    {
        if ($amount instanceof Money) {
            return $this->factory->createWithObjects($amount, $tax);
        }

        if (null === $currency) {
            return $this->factory->createWithValuesAndDefaultCurrency($amount, $tax);
        }

        return $this->factory->createWithValues($amount, $tax, $currency);
    }

    /**
     * staticCreateTaxedPrice
     *
     * @param Money|float $amount
     * @param Money|float $tax
     * @param string      $currency
     *
     * @return TaxedPrice
     */
    public static function staticCreate($amount, $tax, $currency = null)
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory->create($amount, $tax, $currency);
    }

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        return new self(new DefaultFactory(
            MoneyFactory::getStaticFactory()->getInternalFactory()
        ));
    }
}
