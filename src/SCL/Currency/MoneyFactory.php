<?php

namespace SCL\Currency;

use SCL\Currency\Factory\MoneyFactory as MoneyFactoryInterface;
use SCL\Currency\Factory\Adapter\ConfigMoneyFactory;

class MoneyFactory
{
    /**
     * @var MoneyFactoryInterface
     */
    private $moneyFactory;

    /**
     * @var Factory
     */
    private static $staticFactory;

    public function __construct(MoneyFactoryInterface $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    /**
     * @return MoneyFactoryInterface
     */
    public function getInternalFactory()
    {
        return $this->moneyFactory;
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
        return new self(
            new ConfigMoneyFactory(
                include __DIR__ . '/../../../config/currencies.php'
            )
        );
    }

    public static function setStaticFactory(MoneyFactory $factory)
    {
        self::$staticFactory = $factory;
    }

    /**
     * Only really intended for testing.
     */
    public static function clearStaticFactory()
    {
        self::$staticFactory = null;
    }

    /**
     * @return Factory
     */
    public static function getStaticFactory()
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory;
    }

    /**
     * @param  float                 $amount
     * @param  string|Currency|null  $currency
     *
     * @return \SCL\Currency\Money
     */
    public static function staticCreateMoney($amount, $currency = null)
    {
        self::assertStaticFactoryHasBeenCreated();

        return self::$staticFactory->create($amount, $currency);
    }

    private static function assertStaticFactoryHasBeenCreated()
    {
        if (!self::$staticFactory) {
            self::$staticFactory = self::createDefaultInstance();
        }
    }
}
