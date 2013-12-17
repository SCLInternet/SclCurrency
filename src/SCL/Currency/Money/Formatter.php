<?php

namespace SCL\Currency\Money;

use SCL\Currency\Money;
use SCL\Currency\Exception\UnknownCurrencyException;

class Formatter
{
    /**
     * @var array
     */
    private $currencies;

    /**
     * @var Money
     */
    private $value;

    /**
     * @var array
     */
    private $config;

    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * @return float
     */
    public function formatAsNumber(Money $value)
    {
        $this->value = $value;

        $this->loadConfig();

        return $this->getValueAsDecimalNumber();
    }


    public function formatAsString(Money $value)
    {
        $this->value = $value;

        $this->loadConfig();

        $result = sprintf(
            '%.' . $this->getPrecision() . 'f',
            $this->getValueAsDecimalNumber()
        );

        if ($this->config['symbol_position'] === 'left') {
            $result = $this->config['symbol_ascii'] . ' ' . $result;
        } else {
            $result .= ' ' . $this->config['symbol_ascii'];
        }

        return $result;
    }

    /**
     * @return Formatter
     */
    public static function createDefaultInstance()
    {
        return new self(include __DIR__ . '/../../../../config/currencies.php');
    }

    private function loadConfig()
    {
        $currencyCode = $this->value->getCurrency()->getCode();

        if (!array_key_exists($currencyCode, $this->currencies)) {
            throw new UnknownCurrencyException($currencyCode);
        }

        $this->config = $this->currencies[$currencyCode];
    }

    /**
     * @return float
     */
    private function getValueAsDecimalNumber()
    {
        return floatval($this->value->getValue() / pow(10, $this->getPrecision()));
    }

    private function getPrecision()
    {
        return $this->config['precision'];
    }
}
