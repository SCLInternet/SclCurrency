<?php

namespace SCL\Currency\Factory\Adapter;

use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Factory\MoneyFactory;
use SCL\Currency\Exception\NoDefaultCurrencyException;

class ConfigMoneyFactory implements MoneyFactory
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

    public function setDefaultCurrency(Currency $currency)
    {
        $this->defaultCurrency = $currency;
    }

    public function createWithCurrencyCode($amount, $code)
    {
        $this->amount       = $amount;
        $this->currencyCode = $code;
        $this->currency     = $this->createCurrency();

        return $this->createMoneyInstance();
    }

    public function createWithCurrency($amount, Currency $currency)
    {
        $this->amount       = $amount;
        $this->currencyCode = $currency->getCode();
        $this->currency     = $currency;

        return $this->createMoneyInstance();
    }

    public function createWithDefaultCurrency($amount)
    {
        if (!$this->defaultCurrency) {
            throw new NoDefaultCurrencyException();
        }

        $this->currencyCode = $this->defaultCurrency->getCode();
        $this->currency     = $this->defaultCurrency;

        return $this->createMoneyInstance();
    }

    /**
     * @return Money
     */
    private function createMoneyInstance()
    {
        return new Money(
            $this->getCurrencyUnits(),
            $this->currency
        );
    }

    /**
     * @return int
     */
    private function getCurrencyUnits()
    {
        $precision = $this->getCurrencyConfig($this->currencyCode)['precision'];

        return intval($this->amount * pow(10, $precision));
    }

    /**
     * @param  string $code
     *
     * @return code
     *
     * @throws UnknownCurrencyException
     */
    private function getCurrencyConfig($code)
    {
        if (!array_key_exists($code, $this->config)) {
            throw new UnknownCurrencyException($code);
        }

        return $this->config[$code];
    }

    /**
     * @param  string $code
     *
     * @return Currency
     */
    private function createCurrency()
    {
        if (!array_key_exists($this->currencyCode, $this->currencies)) {
            $this->currencies[$this->currencyCode] = new Currency($this->currencyCode);
        }

        return $this->currencies[$this->currencyCode];
    }
}
