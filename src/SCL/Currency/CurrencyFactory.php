<?php

namespace SCL\Currency;

use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Factory\AbstractFactoryFacade;

class CurrencyFactory
{
    private $config;

    private $currencies = array();

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function create($code)
    {
        if (!array_key_exists($code, $this->currencies)) {
            $this->assertCurrencyExists($code);

            $config = $this->config[$code];

            $this->currencies[$code] = new Currency($code, $config['precision']);
        }

        return $this->currencies[$code];
    }

    private function assertCurrencyExists($code)
    {
        if (!array_key_exists($code, $this->config)) {
            throw new UnknownCurrencyException($code);
        }
    }

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        return new self(
            include __DIR__ . '/../../../config/currencies.php'
        );
    }
}
