<?php

namespace spec\SCL\Currency\TaxedPrice;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\TaxedPrice;
use SCL\Currency\Money;
use SCL\Currency\Exception\CurrencyMismatchException;

class AccumulatorSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new Currency('GBP', 2));
    }

    public function it_sets_currency_with_single_price_object()
    {
        $this->calculateTotal()->getCurrency()->getCode()->shouldReturn('GBP');
    }

    public function it_returns_total_equal_to_single_added_price()
    {
        $this->add($this->createPrice(10, 2));

        $this->totalShouldBe(10, 2);
    }

    public function it_returns_zero_for_empty_accumulator()
    {
        $this->totalShouldBe(0, 0);
    }

    public function it_returns_total_equal_to_2_added_values()
    {
        $this->add($this->createPrice(100, 10));
        $this->add($this->createPrice(10, 1));

        $this->totalShouldBe(110, 11);
    }

    public function it_should_throw_if_currencies_do_not_match()
    {
        $this->shouldThrow(new CurrencyMismatchException('USD'))
             ->duringAdd($this->createPrice(5, 1, 'USD'));
    }

    private function totalShouldBe($amountUnits, $taxUnits)
    {
        $this->calculateTotal()->getAmount()->getUnits()->shouldReturn($amountUnits);
        $this->calculateTotal()->getTax()->getUnits()->shouldReturn($taxUnits);
    }

    private function createPrice($amountUnits, $taxUnits, $currencyCode = 'GBP')
    {
        $currency = new Currency($currencyCode, 2);

        return new TaxedPrice(
            new Money($amountUnits, $currency),
            new Money($taxUnits, $currency)
        );
    }
}
