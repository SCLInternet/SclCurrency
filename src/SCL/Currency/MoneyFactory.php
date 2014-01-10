<?php

namespace SCL\Currency;

use SCL\Currency\Money\Factory as Factory;
use SCL\Currency\Money\ConfigFactory;
use SCL\Currency\Factory\AbstractFactoryFacade;
use SCL\Currency\Currency;
use SCL\Currency\Exception\NoDefaultCurrencyException;
use SCL\Currency\CurrencyFactory;

class MoneyFactory
{
    /**
     * @var CurrencyFactory
     */
    private $currencyFactory;

    /**
     * @return MoneyFactory
     */
    public static function createDefaultInstance()
    {
        return new self(CurrencyFactory::createDefaultInstance());
    }

    public function __construct(CurrencyFactory $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;
    }

    /**
     * @param float $value
     *
     * @return Money
     */
    public function createFromValue($value)
    {
        return Money::createFromValue($value, $this->getDefaultCurrency());
    }

    /**
     * @param int $value
     *
     * @return Money
     */
    public function createFromUnits($units)
    {
        return Money::createFromUnits($units, $this->getDefaultCurrency());
    }

    public function setDefaultCurrency(Currency $currency)
    {
        $this->defaultCurrency = $currency;
    }

    /**
     * @return Currency
     */
    public function getDefaultCurrency()
    {
        return $this->currencyFactory->getDefaultCurrency();
    }
}
