<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\CurrencyValue;
use SCL\Currency\TaxRate;

class TaxCalculatorSpec extends ObjectBehavior
{
    public function it_calculates_tax_from_amount_and_rate()
    {
        $this->calculateTaxAmount(
            new CurrencyValue(100),
            new TaxRate(20)
        )->shouldBeLike(new CurrencyValue(20));
    }

    public function it_calculates_tax_from_amount_and_rate_with_long_precision()
    {
        $this->calculateTaxAmount(
            new CurrencyValue(1.11),
            new TaxRate(17.3)
        )->shouldBeLike(new CurrencyValue(0.19));
    }

    public function it_calculates_taxRate_from_amount_and_tax_amount()
    {
        $this->calculateTaxRate(
            new CurrencyValue(100),
            new CurrencyValue(20)
        )->shouldReturn(20.0);
    }

    public function it_extracts_the_tax_amount_from_inc_tax_amount_and_rate()
    {
        $this->extractTaxAmount(
            new CurrencyValue(120),
            new TaxRate(20)
        )->shouldBeLike(new CurrencyValue(20));
    }

    public function it_extacts_the_tax_amount_from_inctax_amount_and_rate_with_long_precision()
    {
        $this->extractTaxAmount(
            new CurrencyValue(1.23),
            new TaxRate(13)
        )->shouldBeLike(new CurrencyValue(0.14));
    }

    public function it_extacts_the_amount_from_inctax_amount_and_rate()
    {
        $this->extractAmount(
            new CurrencyValue(120),
            new TaxRate(20)
        )->shouldBeLike(new CurrencyValue(100));
    }
}
