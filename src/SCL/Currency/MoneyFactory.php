<?php

namespace SCL\Currency;

use SCL\Currency\Money\Factory as Factory;
use SCL\Currency\Money\ConfigFactory;
use SCL\Currency\Factory\AbstractFactoryFacade;

class MoneyFactory extends AbstractFactoryFacade
{
    /**
     * @param float                $amount
     * @param string|Currency|null $currency
     *
     * @return \SCL\Currency\Money
     */
    public function create($amount, $currency = null)
    {
        if (null === $currency) {
            return $this->factory->createWithDefaultCurrency($amount);
        }

        if ($currency instanceof Currency) {
            return $this->factory->createWithCurrency($amount, $currency);
        }

        return $this->factory->createWithCurrencyCode($amount, $currency);
    }

    /**
     * @param float                $amount
     * @param string|Currency|null $currency
     *
     * @return \SCL\Currency\Money
     */
    public static function staticCreate($amount, $currency = null)
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory->create($amount, $currency);
    }

    /**
     * @return Factory
     */
    public function getInternalFactory()
    {
        return $this->factory;
    }

    public function setDefaultCurrency(Currency $currency)
    {
        $this->factory->setDefaultCurrency($currency);
    }

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        return new self(
            new ConfigFactory(
                include __DIR__ . '/../../../config/currencies.php'
            )
        );
    }
}
