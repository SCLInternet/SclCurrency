<?php

namespace SCL\Currency\Money;

use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Exception\NoDefaultCurrencyException;

class ConfigFactory implements Factory
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var Currency[]
     */
    private $currencies = array();

    /**
     * @var Currency
     */
    private $defaultCurrency;

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var float
     */
    private $amount;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function createFromUnitsWithCurrencyCode($amount, $code)
    {
        $this->amount       = $amount;
        $this->currencyCode = $code;
        $this->currency     = $this->createCurrency();

        return $this->createMoneyInstance();
    }

    public function createFromUnitsWithCurrency($amount, Currency $currency)
    {
        $this->amount       = $amount;
        $this->currencyCode = $currency->getCode();
        $this->currency     = $currency;

        return $this->createMoneyInstance();
    }

    public function createFromUnitsWithDefaultCurrency($amount)
    {
        if (!$this->defaultCurrency) {
            throw new NoDefaultCurrencyException();
        }

        $this->amount       = $amount;
        $this->currencyCode = $this->defaultCurrency->getCode();
        $this->currency     = $this->defaultCurrency;

        return $this->createMoneyInstance();
    }

    public function createWithCurrencyCode($amount, $code)
    {
        return $this->createFromUnitsWithCurrencyCode(
            $this->removePrecision($amount, $code),
            $code
        );
    }

    public function createWithCurrency($amount, Currency $currency)
    {
        return $this->createFromUnitsWithCurrency(
            $this->removePrecision($amount, $currency->getCode()),
            $currency
        );
    }

    public function createWithDefaultCurrency($amount)
    {
        if (!$this->defaultCurrency) {
            throw new NoDefaultCurrencyException();
        }

        return $this->createFromUnitsWithDefaultCurrency(
            $this->removePrecision($amount, $this->defaultCurrency->getCode())
        );
    }

    public function setDefaultCurrency(Currency $currency)
    {
        $this->defaultCurrency = $currency;
    }

    /**
     * @param int    $amount
     * @param string $currencyCode
     *
     * @return float
     */
    private function removePrecision($amount, $currencyCode)
    {
        $this->currencyCode = $currencyCode;

        $calculator = null;

        if (!$calculator) {
            $config = $this->getCurrencyConfig();
            $calculator = new NumberScaler($config['precision']);
        }

        return $calculator->removePrecision($amount);
    }

    /**
     * @return Money
     */
    private function createMoneyInstance()
    {
        $this->assertKnownCurrency();

        return new Money($this->amount, $this->currency);
    }

    /**
     * @param string $code
     *
     * @return code
     *
     * @throws UnknownCurrencyException
     */
    private function getCurrencyConfig()
    {
        $this->assertKnownCurrency();

        return $this->config[$this->currencyCode];
    }

    /**
     * @param string $code
     *
     * @return Currency
     */
    private function createCurrency()
    {
        $this->assertKnownCurrency();

        if (!array_key_exists($this->currencyCode, $this->currencies)) {
            $this->currencies[$this->currencyCode] = new Currency($this->currencyCode);
        }

        return $this->currencies[$this->currencyCode];
    }

    private function assertKnownCurrency()
    {
        if (!array_key_exists($this->currencyCode, $this->config)) {
            throw new UnknownCurrencyException($this->currencyCode);
        }
    }
}
