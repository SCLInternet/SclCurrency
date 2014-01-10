<?php

namespace spec\SCL\Currency\Money;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\Money;
use SCL\Currency\Exception\CurrencyMismatchException;

class AccumulatorSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new Currency('GBP', 2));
    }

    public function it_sets_currency_with_single_money_object()
    {
        $this->add($this->createMoney(10));

        $this->calculateTotal()->getCurrency()->getCode()->shouldReturn('GBP');
    }

    public function it_returns_total_equal_to_single_added_value()
    {
        $this->add($this->createMoney(10));

        $this->calculateTotal()->getUnits()->shouldReturn(10);
    }

    public function it_returns_zero_for_empty_accumulator()
    {
        $this->calculateTotal()->getUnits()->shouldReturn(0);
    }

    public function it_returns_total_equal_to_2_added_values()
    {
        $this->add($this->createMoney(10));
        $this->add($this->createMoney(1));

        $this->calculateTotal()->getUnits()->shouldReturn(11);
    }

    public function it_should_throw_if_currencies_do_not_match()
    {
        $this->shouldThrow(new CurrencyMismatchException('USD'))
             ->duringAdd($this->createMoney(5, 'USD'));
    }

    private function createMoney($units, $currency = 'GBP')
    {
        return new Money($units, new Currency($currency, 2));
    }
}
