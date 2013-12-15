<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\CurrencyValue;
use SCL\Currency\Exception\PrecisionMismatchException;

class CurrencyCalculatorSpec extends ObjectBehavior
{
    public function it_makes_add_throw_for_a_precision_mismatch()
    {
        $this->shouldThrow(new PrecisionMismatchException())
             ->duringAdd(
                new CurrencyValue(0, 2),
                new CurrencyValue(0, 3)
             );
    }

    public function it_adds_2_currency_values_together()
    {
        $this->add(
            new CurrencyValue(4),
            new CurrencyValue(5)
        )->shouldBeLike(new CurrencyValue(9));
    }

    public function it_subtracts_1_value_from_another()
    {
        $this->subtract(
            new CurrencyValue(5),
            new CurrencyValue(3)
        )->shouldBeLike(new CurrencyValue(2));
    }

    public function it_does_not_suffer_from_floating_point_errors_when_subtracting()
    {
        $this->subtract(
            new CurrencyValue(69.1),
            new CurrencyValue(69)
        )->shouldBeLike(new CurrencyValue(0.1));
    }
}
