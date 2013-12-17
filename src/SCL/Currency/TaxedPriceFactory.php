<?php

namespace SCL\Currency;

use SCL\Currency\TaxedPrice\Factory;
use SCL\Currency\TaxedPrice\DefaultFactory;

class TaxedPriceFactory
{
    /**
     * @var Factory
     */
    private $priceFactory;

    /**
     * @var Factory
     */
    private static $staticFactory;

    public function __construct(Factory $priceFactory)
    {
        $this->priceFactory = $priceFactory;
    }

    /**
     * @param Money|float $amount
     * @param Money|float $tax
     * @param string      $currency
     *
     * @return TaxedPrice
     */
    public function createTaxedPrice($amount, $tax, $currency = null)
    {
        if ($amount instanceof Money) {
            return $this->priceFactory->createWithObjects($amount, $tax);
        }

        if (null === $currency) {
            return $this->priceFactory->createWithValuesAndDefaultCurrency($amount, $tax);
        }

        return $this->priceFactory->createWithValues($amount, $tax, $currency);
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

    public static function setStaticFactory(TaxedPriceFactory $factory)
    {
        self::$staticFactory = $factory;
    }

    /**
     * Only really intended for testing.
     */
    public static function clearStaticFactory()
    {
        self::$staticFactory = null;
    }

    /**
     * @return Factory
     */
    public static function getStaticFactory()
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory;
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
    public function staticCreateTaxedPrice($amount, $tax, $currency = null)
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory->createTaxedPrice($amount, $tax, $currency);
    }

    private static function assertStaticFactoryHasBeenCreated()
    {
        if (!self::$staticFactory) {
            self::$staticFactory = self::createDefaultInstance();
        }
    }
}
