<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Money;
use SCL\Currency\TaxRate;
use SCL\Currency\Currency;

class TaxCalculatorSpec extends ObjectBehavior
{
    public function it_calculates_tax_from_amount_and_rate()
    {
        $this->calculateTaxAmount(
            $this->createMoney(100),
            new TaxRate(20)
        )->shouldBeLike($this->createMoney(20));
    }

    public function it_calculates_tax_from_amount_and_rate_with_long_precision()
    {
        $this->calculateTaxAmount(
            $this->createMoney(111),
            new TaxRate(17.3)
        )->shouldBeLike($this->createMoney(19));
    }

    public function it_returns_TaxRate_from_calculateTaxRate()
    {
        $this->calculateTaxRate(
            $this->createMoney(100),
            $this->createMoney(20)
        )->shouldReturnAnInstanceOf('SCL\Currency\TaxRate');
    }

    public function it_calculates_taxRate_from_amount_and_tax_amount()
    {
        $this->calculateTaxRate(
            $this->createMoney(100),
            $this->createMoney(20)
        )->getPercentage()->shouldReturn(20.0);
    }

    public function it_extracts_the_tax_amount_from_inc_tax_amount_and_rate()
    {
        $this->extractTaxAmount(
            $this->createMoney(120),
            new TaxRate(20)
        )->shouldBeLike($this->createMoney(20));
    }

    public function it_extacts_the_tax_amount_from_inctax_amount_and_rate_with_long_precision()
    {
        $this->extractTaxAmount(
            $this->createMoney(123),
            new TaxRate(13)
        )->shouldBeLike($this->createMoney(14));
    }

    public function it_extacts_the_amount_from_inctax_amount_and_rate()
    {
        $this->extractAmount(
            $this->createMoney(120),
            new TaxRate(20)
        )->shouldBeLike($this->createMoney(100));
    }

    /**
     * @param  int   $amount
     *
     * @return Money
     */
    private function createMoney($amount)
    {
        return new Money($amount, new Currency('GBP'));
    }
}
