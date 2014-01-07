<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\Exception\PrecisionMismatchException;

class CurrencySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('GBP', 2);
    }

    public function it_stores_the_code()
    {
        $this->getCode()->shouldReturn('GBP');
    }

    public function it_stores_the_precision()
    {
        $this->getPrecision()->shouldReturn(2);
    }

    public function it_ignores_decimal_parts_of_precision()
    {
        $this->beConstructedWith('XXX', 3.2);

        $this->getPrecision()->shouldReturn(3);
    }

    public function it_removes_a_precision_of_2_from_a_value()
    {
        $this->beConstructedWith('XXX', 2);

        $this->removePrecision(1.23)->shouldReturn(123);
    }

    public function it_removes_a_precision_of_3_from_a_value()
    {
        $this->beConstructedWith('XXX', 3);

        $this->removePrecision(4.567)->shouldReturn(4567);
    }

    public function it_adds_precision_of_2_to_a_value()
    {
        $this->beConstructedWith('XXX', 2);

        $this->addPrecision(123)->shouldReturn(1.23);
    }

    public function it_adds_a_precision_of_3_from_a_value()
    {
        $this->beConstructedWith('XXX', 3);

        $this->addPrecision(4567)->shouldReturn(4.567);
    }

    public function it_is_not_equal_to_currency_with_a_different_code()
    {
        $other = new Currency('USD', 2);

        $this->isEqualTo($other)->shouldReturn(false);
    }

    public function it_is_equal_to_currency_with_a_same_code()
    {
        $other = new Currency('GBP', 2);

        $this->isEqualTo($other)->shouldReturn(true);
    }

    public function it_throws_if_equal_codes_mismatch_precision()
    {
        $other = new Currency('GBP', 1);

        $this->shouldThrow(PrecisionMismatchException::create('GBP', 2, 1))
             ->duringIsEqualTo($other);
    }
}
