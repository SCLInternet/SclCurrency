<?php

namespace SCL\Currency;

use SCL\Currency\Factory\MoneyFactory;
use SCL\Currency\Factory\Adapter\ConfigMoneyFactory;

class Factory
{
    private $moneyFactory;

    public function __construct(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    /**
     * @param  float                 $amount
     * @param  string|Currency|null  $currency
     *
     * @return \SCL\Currency\Money
     */
    public function create($amount, $currency = null)
    {
        if (null === $currency) {
            return $this->moneyFactory->createWithDefaultCurrency($amount);
        }

        if ($currency instanceof Currency) {
            return $this->moneyFactory->createWithCurrency($amount, $currency);
        }

        return $this->moneyFactory->createWithCurrencyCode($amount, $currency);
    }

    public function setDefaultCurrency(Currency $currency)
    {
        $this->moneyFactory->setDefaultCurrency($currency);
    }

    /**
     * @return Factory
     */
    public static function createDefaultInstance()
    {
        return new self(new ConfigMoneyFactory(
            include __DIR__ . '/../../../config/currencies.php'
        ));
    }
}
