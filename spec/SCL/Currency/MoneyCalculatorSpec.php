<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Money;
use SCL\Currency\Exception\CurrencyMismatchException;
use SCL\Currency\Currency;

class MoneyCalculatorSpec extends ObjectBehavior
{
    private $currency;

    public function let()
    {
        $this->currency = new Currency('GBP');
    }

    public function it_makes_add_throw_for_a_currency_mismatch()
    {
        $this->shouldThrow(new CurrencyMismatchException())
             ->duringAdd(
                new Money(0, new Currency('GBP')),
                new Money(0, new Currency('USD'))
             );
    }

    public function it_adds_2_currency_values_together()
    {
        $this->add(
            new Money(4, $this->currency),
            new Money(5, $this->currency)
        )->shouldBeLike(new Money(9, $this->currency));
    }

    public function it_makes_subtract_throw_for_a_currency_mismatch()
    {
        $this->shouldThrow(new CurrencyMismatchException())
             ->duringSubtract(
                new Money(0, new Currency('GBP')),
                new Money(0, new Currency('USD'))
             );
    }

    public function it_subtracts_1_value_from_another()
    {
        $this->subtract(
            new Money(5, $this->currency),
            new Money(3, $this->currency)
        )->shouldBeLike(new Money(2, $this->currency));
    }
}
