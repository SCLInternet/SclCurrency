<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\CurrencyFactory;

class MoneyFactorySpec extends ObjectBehavior
{
    private $currencyFactory;

    public function let(CurrencyFactory $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;

        $this->beConstructedWith($currencyFactory);
    }

    /*
     * createFromValue()
     */

    public function it_returns_Money_from_createFromValue()
    {
        $this->setDefaultCurrency(new Currency('XXX', 2));

        $this->createFromValue(1.00)
             ->shouldReturnAnInstanceOf('SCL\Currency\Money');
    }

    public function it_loads_uses_default_currency_to_convert_to_units_in_createFromValue(Currency $currency)
    {
        $currency->removePrecision(1.0)->shouldBeCalled()->willReturn(0);

        $this->setDefaultCurrency($currency);

        $this->createFromValue(1.00);
    }

    public function it_sets_money_units_in_createFromValue(Currency $currency)
    {
        $currency->removePrecision(Argument::any())->willReturn(500);

        $this->setDefaultCurrency($currency);

        $this->createFromValue(0)->getUnits()->shouldReturn(500);
    }

    public function it_sets_money_currency_in_createFromValue()
    {
        $currency = new Currency('XXX', 2);

        $this->setDefaultCurrency($currency);

        $this->createFromValue(0)->getCurrency()->shouldReturn($currency);
    }

    /*
     * createFromUnits()
     */

    public function it_returns_Money_from_createFromUnits()
    {
        $this->setDefaultCurrency(new Currency('XXX', 2));

        $this->createFromUnits(100)
             ->shouldReturnAnInstanceOf('SCL\Currency\Money');
    }

    public function it_sets_money_units_in_createFromUnits()
    {
        $this->setDefaultCurrency(new Currency('XXX', 2));

        $this->createFromUnits(100)->getUnits()->shouldReturn(100);
    }

    public function it_sets_money_currency_in_createFromUnits()
    {
        $currency = new Currency('XXX', 2);

        $this->setDefaultCurrency($currency);

        $this->createFromUnits(0)->getCurrency()->shouldReturn($currency);
    }

    /*
     * getDefaultCurrency()
     */

    public function it_returns_the_default_currency()
    {
        $currency = new Currency('XXX', 2);

        $this->setDefaultCurrency($currency);

        $this->getDefaultCurrency()->shouldReturn($currency);
    }

    /*
     * createDefaultInstance()
     */

    public function it_returns_instance_from_createDefaultInstance()
    {
        $this::createDefaultInstance()->shouldReturnAnInstanceOf('SCL\Currency\MoneyFactory');
    }

    /*
     * private methods
     */

    private function setDefaultCurrency(Currency $currency)
    {
        $this->currencyFactory->getDefaultCurrency()->willReturn($currency);
    }
}
