<?php

namespace spec\SCL\Currency\Money;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Currency;
use SCL\Currency\Exception\NoDefaultCurrencyException;

class ConfigFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $config = array(
            'GBP' => array(
                'name'            => 'Great British Pounds',
                'precision'       => '2',
                'separator'       => '.',
                'symbol_ascii'    => '£',
                'symbol_html'     => '&pound;',
                'symbol_position' => 'left',
            ),
            'BTC' => array(
                'name'            => 'BitCoins',
                'precision'       => '8',
                'separator'       => '.',
                'symbol_ascii'    => 'BTC',
                'symbol_html'     => 'BTC',
                'symbol_position' => 'right',
            ),
        );

        $this->beConstructedWith($config);
    }

    public function it_is_a_MoneyFactory()
    {
        $this->shouldBeAnInstanceOf('SCL\Currency\Money\Factory');
    }

    /*
     * createWithCurrencyCode()
     */

    public function it_creates_a_money_object_from_currency_code()
    {
        $this->createWithCurrencyCode(0, 'GBP')
             ->shouldReturnAnInstanceOf('SCL\Currency\Money');
    }

    public function it_throws_for_unknown_currency_when_using_currency_code()
    {
        $this->shouldThrow(new UnknownCurrencyException('UNK'))
             ->duringCreateWithCurrencyCode(0, 'UNK');
    }

    public function it_sets_the_currency_from_currency_code()
    {
        $this->createWithCurrencyCode(0, 'GBP')
             ->getCurrency()
             ->getCode()
             ->shouldReturn('GBP');
    }

    public function it_sets_amount_using_config_precision_from_currency_code()
    {
        $this->createWithCurrencyCode(1.0, 'GBP')->getValue()->shouldReturn(100);
        $this->createWithCurrencyCode(1.0, 'BTC')->getValue()->shouldReturn(100000000);
    }

    public function it_reuses_same_currencies_from_currency_code()
    {
        $currency = $this->createWithCurrencyCode(0, 'GBP')->getCurrency();

        $this->createWithCurrencyCode(0, 'GBP')->getCurrency()->shouldReturn($currency);
    }

    /*
     * createWithCurrency()
     */

    public function it_creates_money_object_from_currency()
    {
        $this->createWithCurrency(0, new Currency('GBP'))
             ->shouldReturnAnInstanceOf('SCL\Currency\Money');
    }

    public function it_creates_money_object_containing_given_currency()
    {
        $currency = new Currency('GBP');

        $this->createWithCurrency(0, $currency)->getCurrency()->shouldReturn($currency);
    }

    public function it_throws_if_given_currency_is_unknown()
    {
        $this->shouldThrow(new UnknownCurrencyException('UNK'))
             ->duringCreateWithCurrency(0, new Currency('UNK'));
    }

    public function it_sets_value_using_precision_from_given_currency()
    {
        $this->createWithCurrency(1.0, new Currency('GBP'))
             ->getValue()
             ->shouldReturn(100);

        $this->createWithCurrency(1.0, new Currency('BTC'))
             ->getValue()
             ->shouldReturn(100000000);
    }

    /*
     * createWithDefaultCurrency()
     */

    public function it_creates_money_object_when_using_default()
    {
        $this->setDefaultCurrency(new Currency('GBP'));

        $this->createWithDefaultCurrency(0)
             ->shouldReturnAnInstanceOf('SCL\Currency\Money');
    }

    public function it_throws_if_no_default_currency_is_set()
    {
        $this->shouldThrow(new NoDefaultCurrencyException())
             ->duringCreateWithDefaultCurrency(0);
    }

    public function it_creates_money_object_containing_default()
    {
        $currency = new Currency('GBP');

        $this->setDefaultCurrency($currency);

        $this->createWithDefaultCurrency(0, $currency)
             ->getCurrency()
             ->shouldReturn($currency);
    }

    public function it_sets_value_using_precision_from_default_currency()
    {
        $currency = new Currency('BTC');

        $this->setDefaultCurrency($currency);

        $this->createWithCurrency(1.0, new Currency('BTC'))
             ->getValue()
             ->shouldReturn(100000000);
    }
}
