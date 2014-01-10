<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\Exception\CurrencyMismatchException;

class TaxedPriceSpec extends ObjectBehavior
{
    private $amount;

    private $tax;

    private $currency;

    public function let()
    {
        $this->currency = new Currency('GBP', 2);

        $this->amount = new Money(10, $this->currency);
        $this->tax    = new Money(2, $this->currency);

        $this->beConstructedWith($this->amount, $this->tax);
    }

    public function it_throws_if_currencies_mismatch()
    {
        $amount = new Money(0, new Currency('GBP', 2));
        $tax    = new Money(0, new Currency('USD', 2));

        $this->shouldThrow(new CurrencyMismatchException())
             ->during('__construct', array($amount, $tax));
    }

    public function it_stores_amount_value()
    {
        $this->getAmount()->shouldReturn($this->amount);
    }

    public function it_stores_tax_value()
    {
        $this->getTax()->shouldReturn($this->tax);
    }

    public function it_calculates_total()
    {
        $this->getTotal()->shouldBeLike(new Money(12, $this->currency));
    }

    public function it_returns_currency()
    {
        $this->getCurrency()->shouldReturn($this->currency);
    }
}
