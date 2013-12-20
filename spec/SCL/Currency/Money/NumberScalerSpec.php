<?php

namespace spec\SCL\Currency\Money;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Exception\NegativePrecisionException;

class NumberScalerSpec extends ObjectBehavior
{
    public function it_adds_precision_of_2()
    {
        $this->beConstructedWith(2);

        $this->addPrecision(100)->shouldReturn(1.0);
    }

    public function it_adds_precision_of_5()
    {
        $this->beConstructedWith(5);

        $this->addPrecision(123456)->shouldReturn(1.23456);
    }

    public function it_removes_precision_of_2()
    {
        $this->beConstructedWith(2);

        $this->removePrecision(1)->shouldReturn(100);
    }

    public function it_removes_precision_of_5()
    {
        $this->beConstructedWith(5);

        $this->removePrecision(1.23456)->shouldReturn(123456);
    }

    public function it_ignores_decimal_parts_of_precision()
    {
        $this->beConstructedWith(2.3);

        $this->addPrecision(100)->shouldReturn(1.0);
        $this->removePrecision(1)->shouldReturn(100);
    }

    public function it_throws_for_negative_precision()
    {
        $this->beConstructedWith(-1);

        $this->shouldThrow(new NegativePrecisionException())
                         ->during('__construct', array(-1));
    }
}
