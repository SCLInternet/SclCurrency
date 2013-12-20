<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
}
