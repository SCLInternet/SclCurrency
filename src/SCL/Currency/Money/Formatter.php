<?php

namespace SCL\Currency\Money;

use SCL\Currency\Config;
use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Money;
use SCL\Currency\Money\Formatter\FormatterContext;

class Formatter
{
    /**
     * @var FormatterContext
     */
    private $context;

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

    /**
     * @return Formatter
     */
    public static function createDefaultInstance(FormatterContext $context)
    {
        return new self(Config::getDefaultConfig(), $context);
    }

    public function __construct(array $currencies, FormatterContext $context)
    {
        $this->currencies = $currencies;
        $this->context    = $context;
    }

    public function format(Money $value)
    {
        $this->value = $value;

        $this->loadConfig();

        $result = $this->getFormattedMoneyValue();

        $result = $this->addCurrencySymbol($result);

        return $result;
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
     * @return string
     */
    private function getFormattedMoneyValue()
    {
        return sprintf(
            '%.' . $this->getPrecision() . 'f',
            $this->value->getValue()
        );
    }

    /**
     * @param string $result
     *
     * @return string
     */
    private function addCurrencySymbol($result)
    {
        $format = ($this->config['symbol_position'] === 'left')
            ? '%1$s %2$s'
            : '%2$s %1$s';

        return sprintf(
            $format,
            $this->context->getCurrencySymbol($this->config),
            $result
        );
    }

    /**
     * @return int
     */
    private function getPrecision()
    {
        return $this->value->getCurrency()->getPrecision();
    }
}
