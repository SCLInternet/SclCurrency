<?php

namespace spec\SCL\Currency\TaxedPrice;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\Money;
use SCL\Currency\Money\Factory as MoneyFactory;

class DefaultFactorySpec extends ObjectBehavior
{
    private $moneyFactory;

    public function let(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;

        $this->beConstructedWith($this->moneyFactory);
    }

    public function it_is_a_taxed_price_factory()
    {
        $this->shouldBeAnInstanceOf('SCL\Currency\TaxedPrice\Factory');
    }

    /*
     * createWithObjects()
     */

    public function it_creates_TaxedPrice_from_objects()
    {
        $amount = $this->createMoney(10);
        $tax = $this->createMoney(2);

        $this->createWithObjects($amount, $tax)
             ->shouldReturnAnInstanceOf('SCL\Currency\TaxedPrice');
    }

    public function it_sets_TaxedPrice_values_from_objects()
    {
        $amount = $this->createMoney(10);
        $tax = $this->createMoney(2);

        $price = $this->createWithObjects($amount, $tax);

        $price->getAmount()->shouldReturn($amount);
        $price->getTax()->shouldReturn($tax);
    }

    /*
     * createWithValues()
     */

    public function it_uses_money_factory_to_create_amount_from_value()
    {
        $this->moneyFactory
             ->createWithCurrencyCode(Argument::any(), Argument::any())
             ->willReturn($this->createMoney(0));

        $this->moneyFactory
             ->createWithCurrencyCode(10, 'GBP')
             ->shouldBeCalled()
             ->willReturn($this->createMoney(10));

        $this->createWithValues(10, 2, 'GBP');
    }

    public function it_uses_money_factory_to_create_tax_from_value()
    {
        $this->moneyFactory
             ->createWithCurrencyCode(Argument::any(), Argument::any())
             ->willReturn($this->createMoney(0));

        $this->moneyFactory
             ->createWithCurrencyCode(2, 'GBP')
             ->shouldBeCalled()
             ->willReturn($this->createMoney(2));

        $this->createWithValues(10, 2, 'GBP');

    }

    public function it_sets_money_from_values_in_TaxedPrice()
    {
        $amount = $this->createMoney(10);
        $tax    = $this->createMoney(2);

        $this->moneyFactory
             ->createWithCurrencyCode(10, 'GBP')
             ->willReturn($amount);

        $this->moneyFactory
             ->createWithCurrencyCode(2, 'GBP')
             ->willReturn($tax);

        $price = $this->createWithValues(10, 2, 'GBP');

        $price->getAmount()->shouldReturn($amount);
        $price->getTax()->shouldReturn($tax);
    }

    /*
     * createWithValuesAndDefaultCurrency()
     */

    public function it_uses_money_factory_to_create_amount_with_default_currency()
    {
        $this->moneyFactory
             ->createWithDefaultCurrency(Argument::any(), Argument::any())
             ->willReturn($this->createMoney(0));

        $this->moneyFactory
             ->createWithDefaultCurrency(10)
             ->shouldBeCalled()
             ->willReturn($this->createMoney(10));

        $this->createWithValuesAndDefaultCurrency(10, 2);
    }

    public function it_uses_money_factory_to_create_tax_with_default_currency()
    {
        $this->moneyFactory
             ->createWithDefaultCurrency(Argument::any(), Argument::any())
             ->willReturn($this->createMoney(0));

        $this->moneyFactory
             ->createWithDefaultCurrency(2)
             ->shouldBeCalled()
             ->willReturn($this->createMoney(10));

        $this->createWithValuesAndDefaultCurrency(10, 2);
    }

    public function it_sets_money_from_default_currencies_values_in_TaxedPrice()
    {
        $amount = $this->createMoney(10);
        $tax    = $this->createMoney(2);

        $this->moneyFactory
             ->createWithDefaultCurrency(10)
             ->willReturn($amount);

        $this->moneyFactory
             ->createWithDefaultCurrency(2)
             ->willReturn($tax);

        $price = $this->createWithValuesAndDefaultCurrency(10, 2);

        $price->getAmount()->shouldReturn($amount);
        $price->getTax()->shouldReturn($tax);
    }

    /**
     * @param int    $amount
     * @param string $currency
     *
     * @return Money
     */
    private function createMoney($amount, $currency='GBP')
    {
        return new Money($amount, new Currency($currency));
    }
}
