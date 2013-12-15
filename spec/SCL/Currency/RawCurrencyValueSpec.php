<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\CurrencyValue;

class RawCurrencyValueSpec extends ObjectBehavior
{
    public function let()
    {
        $value = new CurrencyValue(2);
        $value->setValue(1.75);

        $this->beConstructedWith($value);
    }

    public function it_extends_CurrencyValue()
    {
        $this->shouldBeAnInstanceOf('SCL\Currency\CurrencyValue');
    }

    public function it_exposes_integer_currency_value()
    {
        $this->getRawValue()->shouldReturn(175);
    }

    public function it_can_set_integer_currency_value()
    {
        $this->setRawValue(200);

        $this->getRawValue()->shouldReturn(200);
    }

    public function it_exposes_precision()
    {
        $this->getPrecision()->shouldReturn(2);
    }

    public function it_forwards_getValue(CurrencyValue $value)
    {
        $value->getValue()->shouldBeCalled();

        $this->beConstructedWith($value);

        $this->getValue();
    }

    public function it_returns_value_from_getValue()
    {
        $this->getValue()->shouldReturn(1.75);
    }

    public function it_forwards_setValue(CurrencyValue $value)
    {
        $value->setValue(1.23)->shouldBeCalled();

        $this->beConstructedWith($value);

        $this->setValue(1.23);
    }

    public function it_forwards_toString(CurrencyValue $value)
    {
        $value->__toString()->shouldBeCalled();

        $this->beConstructedWith($value);

        $this->__toString();
    }

    public function it_returns_output_from_toString()
    {
        $this->__toString()->shouldReturn('1.75');
    }
}
