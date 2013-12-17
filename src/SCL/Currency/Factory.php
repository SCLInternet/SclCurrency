<?php

namespace SCL\Currency;

use SCL\Currency\Factory\MoneyFactory;
use SCL\Currency\Factory\Adapter\ConfigMoneyFactory;
use SCL\Currency\Factory\TaxedPriceFactory;
use SCL\Currency\Factory\Adapter\DefaultTaxedPriceFactory;

class Factory
{
    /**
     * @var MoneyFactory
     */
    private $moneyFactory;

    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    /**
     * @var Factory
     */
    private static $staticFactory;

    public function __construct(MoneyFactory $moneyFactory, TaxedPriceFactory $priceFactory)
    {
        $this->moneyFactory = $moneyFactory;
        $this->priceFactory = $priceFactory;
    }

    /**
     * @param  float                 $amount
     * @param  string|Currency|null  $currency
     *
     * @return \SCL\Currency\Money
     */
    public function createMoney($amount, $currency = null)
    {
        if (null === $currency) {
            return $this->moneyFactory->createWithDefaultCurrency($amount);
        }

        if ($currency instanceof Currency) {
            return $this->moneyFactory->createWithCurrency($amount, $currency);
        }

        return $this->moneyFactory->createWithCurrencyCode($amount, $currency);
    }

    /**
     * @param  Money|float $amount
     * @param  Money|float $tax
     * @param  string      $currency
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

    public function setDefaultCurrency(Currency $currency)
    {
        $this->moneyFactory->setDefaultCurrency($currency);
    }

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        $moneyFactory = new ConfigMoneyFactory(
            include __DIR__ . '/../../../config/currencies.php'
        );

        $priceFactory = new DefaultTaxedPriceFactory($moneyFactory);

        return new self($moneyFactory, $priceFactory);
    }

    public static function setStaticFactory(Factory $factory)
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
     * @param  float                 $amount
     * @param  string|Currency|null  $currency
     *
     * @return \SCL\Currency\Money
     */
    public static function staticCreateMoney($amount, $currency = null)
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory->createMoney($amount, $currency);
    }

    /**
     * staticCreateTaxedPrice
     *
     * @param  Money|float $amount
     * @param  Money|float $tax
     * @param  string      $currency
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
            self::$staticFactory = Factory::createDefaultInstance();
        }
    }
}
