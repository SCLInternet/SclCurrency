<?php

namespace SCL\Currency;

use SCL\Currency\Money\Factory as Factory;
use SCL\Currency\Money\ConfigFactory;
use SCL\Currency\Factory\AbstractFactoryFacade;
use SCL\Currency\Currency;
use SCL\Currency\Exception\NoDefaultCurrencyException;

class MoneyFactory
{
    private $defaultCurrency;

    public function createFromValue($value)
    {
        $this->assertDefaultCurrencyIsSet();

        $units = $this->defaultCurrency->removePrecision($value);

        return new Money($units, $this->defaultCurrency);
    }

    public function createFromUnits($units)
    {
        $this->assertDefaultCurrencyIsSet();

        return new Money($units, $this->defaultCurrency);
    }

    public function setDefaultCurrency(Currency $currency)
    {
        $this->defaultCurrency = $currency;
    }

    private function assertDefaultCurrencyIsSet()
    {
        if (!$this->defaultCurrency) {
            throw new NoDefaultCurrencyException();
        }
    }
}
