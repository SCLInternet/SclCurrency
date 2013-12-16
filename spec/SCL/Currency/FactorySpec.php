<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Factory\MoneyFactory;
use SCL\Currency\Currency;
use SCL\Currency\Money;
class FactorySpec extends ObjectBehavior
{
    private $moneyFactory;

    public function let(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;

        $this->beConstructedWith($this->moneyFactory);
    }

    public function it_creates_money_using_given_currency()
    {
        $currency = new Currency('GBP');
        $amount   = 55.50;

        $this->moneyFactory
             ->createWithCurrency($amount, $currency)
             ->shouldBeCalled();

        $this->create($amount, $currency);
    }

    public function it_returns_created_money_from_given_currency()
    {
        $money = new Money(0, new Currency('GBP'));

        $this->moneyFactory
             ->createWithCurrency(Argument::any(), Argument::any())
             ->willReturn($money);

        $this->create(0, new Currency('GBP'))->shouldReturn($money);
    }

    public function it_creates_money_using_currency_code()
    {
        $currency = 'GBP';
        $amount   = 55.50;

        $this->moneyFactory
             ->createWithCurrencyCode($amount, $currency)
             ->shouldBeCalled();

        $this->create($amount, $currency);
    }

    public function it_returns_created_money_from_currency_code()
    {
        $money = new Money(0, new Currency('GBP'));

        $this->moneyFactory
             ->createWithCurrencyCode(Argument::any(), Argument::any())
             ->willReturn($money);

        $this->create(0, 'GBP')->shouldReturn($money);
    }

    public function it_creates_money_using_default_currency()
    {
        $amount   = 55.50;

        $this->moneyFactory
             ->createWithDefaultCurrency($amount)
             ->shouldBeCalled();

        $this->create($amount);
    }

    public function it_returns_created_money_from_default_currency()
    {
        $money = new Money(0, new Currency('GBP'));

        $this->moneyFactory
             ->createWithDefaultCurrency(Argument::any())
             ->willReturn($money);

        $this->create(0)->shouldReturn($money);
    }

    public function it_sets_default_currency()
    {
        $currency = new Currency('GBP');

        $this->moneyFactory
             ->setDefaultCurrency($currency)
             ->shouldBeCalled();

        $this->setDefaultCurrency($currency);
    }

    /*
     * createDefaultFactory()
     */

    public function it_create_a_default_instance_of_Factory()
    {
        $this::createDefaultInstance()->shouldReturnAnInstanceOf('SCL\Currency\Factory');
    }

    public function it_creates_a_default_instance_with_some_config()
    {
        $factory = $this::createDefaultInstance();

        // With throw if currency GBP is no found so proves the config has been read
        $factory->create(10, 'GBP')->shouldReturnAnInstanceOf('SCL\Currency\Money');
    }
}
