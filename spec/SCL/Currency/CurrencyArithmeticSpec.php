<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\CurrencyValue;
use SCL\Currency\Exception\PrecisionMismatchException;

class CurrencyArithmeticSpec extends ObjectBehavior
{
    public function it_makes_add_throw_for_a_precision_mismatch()
    {
        $this->shouldThrow(new PrecisionMismatchException())
             ->duringAdd(
                CurrencyValue::createFromValue(0, 2),
                CurrencyValue::createFromValue(0, 3)
             );
    }

    public function it_adds_2_currency_values_together()
    {
        $this->add(
            CurrencyValue::createFromValue(4),
            CurrencyValue::createFromValue(5)
        )->shouldBeLike(CurrencyValue::createFromValue(9));
    }

    public function it_subtracts_1_value_from_another()
    {
        $this->subtract(
            CurrencyValue::createFromValue(5),
            CurrencyValue::createFromValue(3)
        )->shouldBeLike(CurrencyValue::createFromValue(2));
    }

    public function it_does_not_suffer_from_floating_point_errors_when_subtracting()
    {
        $this->subtract(
            CurrencyValue::createFromValue(69.1),
            CurrencyValue::createFromValue(69)
        )->shouldBeLike(CurrencyValue::createFromValue(0.1));
    }
}
