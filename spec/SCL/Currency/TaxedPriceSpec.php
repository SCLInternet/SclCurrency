<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\CurrencyValue;

class TaxedPriceSpec extends ObjectBehavior
{
    public function it_stores_amount_value()
    {
        $amount = new CurrencyValue(10);

        $this->setAmount($amount);

        $this->getAmount()->shouldReturn($amount);
    }

    public function it_defaults_to_zero_amount()
    {
        $this->getAmount()->getValue()->shouldReturn(0.0);
    }

    public function it_stores_tax_value()
    {
        $tax = new CurrencyValue(10);

        $this->setTax($tax);

        $this->getTax()->shouldReturn($tax);
    }

    public function it_defaults_to_zero_tax()
    {
        $this->getTax()->getValue()->shouldReturn(0.0);
    }


    public function it_calculates_total()
    {
        $this->setAmount(new CurrencyValue(10));
        $this->setTax(new CurrencyValue(2));

        $this->getTotal()->shouldBeLike(new CurrencyValue(12));
    }
}
