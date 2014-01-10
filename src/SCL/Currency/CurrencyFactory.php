<?php

namespace SCL\Currency;

use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Factory\AbstractFactoryFacade;

class CurrencyFactory
{
    /**
     * @todo Move this to confuration.
     */
    const DEFAULT_DEFAULT_CURRENCY = 'GBP';

    /**
     * @var array
     */
    private $config;

    /**
     * @var Currency[]
     */
    private $currencies = array();

    /**
     * @var string
     */
    private $defaultCurrencyCode;

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        return new self(
            include __DIR__ . '/../../../config/currencies.php',
            self::DEFAULT_DEFAULT_CURRENCY
        );
    }

    /**
     * @param array  $config
     * @param string $defaultCurrencyCode
     */
    public function __construct(array $config, $defaultCurrencyCode)
    {
        $this->config              = $config;
        $this->defaultCurrencyCode = (string) $defaultCurrencyCode;
    }

    /**
     * @return Currency
     */
    public function create($code)
    {
        if (!array_key_exists($code, $this->currencies)) {
            $this->assertCurrencyExists($code);

            $config = $this->config[$code];

            $this->currencies[$code] = new Currency($code, $config['precision']);
        }

        return $this->currencies[$code];
    }

    /**
     * @return Currency
     */
    public function getDefaultCurrency()
    {
        return $this->create($this->defaultCurrencyCode);
    }

    /**
     * @throws UnknownCurrencyException
     */
    private function assertCurrencyExists($code)
    {
        if (!array_key_exists($code, $this->config)) {
            throw new UnknownCurrencyException($code);
        }
    }
}
