<?php

namespace SCL\Currency;

use SCL\Currency\Money\Factory as Factory;
use SCL\Currency\Money\ConfigFactory;
use SCL\Currency\Factory\AbstractFactoryFacade;
use SCL\Currency\Currency;
use SCL\Currency\Exception\NoDefaultCurrencyException;

class MoneyFactory
{
    /**
     * @var Currency
     */
    private $defaultCurrency;

    /**
     * @return MoneyFactory
     */
    public static function createDefaultInstance()
    {
        return new self();
    }

    /**
     * @param float $value
     *
     * @return Money
     */
    public function createFromValue($value)
    {
        $this->assertDefaultCurrencyIsSet();

        $units = $this->defaultCurrency->removePrecision($value);

        return new Money($units, $this->defaultCurrency);
    }

    /**
     * @param int $value
     *
     * @return Money
     */
    public function createFromUnits($units)
    {
        $this->assertDefaultCurrencyIsSet();

        return new Money($units, $this->defaultCurrency);
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
        return $this->defaultCurrency;
    }

    private function assertDefaultCurrencyIsSet()
    {
        if (!$this->defaultCurrency) {
            throw new NoDefaultCurrencyException();
        }
    }
}
