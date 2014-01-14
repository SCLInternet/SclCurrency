<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior; use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\Money;
use SCL\Currency\Exception\CurrencyMismatchException;

class MoneySpec extends ObjectBehavior
{
    private $currency;

    private $units;

    public function let()
    {
        $this->currency = new Currency('GBP', 2);

        $this->units = 1199;

        $this->beConstructedWith($this->units, $this->currency);
    }

    public function it_returns_currency()
    {
        $this->getCurrency()->shouldReturn($this->currency);
    }

    public function it_returns_units()
    {
        $this->getUnits()->shouldReturn($this->units);
    }

    public function it_returns_value()
    {
        $this->getValue()->shouldReturn(11.99);
    }

    public function it_is_not_zero_for_values_other_than_0()
    {
        $this->shouldNotBeZero();
    }

    public function it_is_zero_for_value_of_0()
    {
        $this->beConstructedWith(0, $this->currency);

        $this->shouldBeZero();
    }

    public function it_is_not_equal_if_currencies_are_not_equal()
    {
        $other = Money::createFromUnits(1199, new Currency('USD', 2));

        $this->isEqualTo($other)->shouldReturn(false);
    }

    public function it_is_equal_if_currencies_and_amounts_match()
    {
        $other = Money::createFromUnits(1199, $this->currency);

        $this->isEqualTo($other)->shouldReturn(true);
        //$this->shouldBeEqualTo($other);
    }

    public function it_is_not_equal_if_amounts_are_not_equal()
    {
        $other = Money::createFromUnits(1100, $this->currency);

        $this->isEqualTo($other)->shouldReturn(false);
    }

    public function it_throws_from_isGreaterThan_if_currencies_mismatch()
    {
        $this->shouldThrow(new CurrencyMismatchException('USD'))
             ->duringIsGreaterThan(new Money(10, new Currency('USD', 2)));
    }

    public function it_is_greater_than_a_money_value_with_a_smaller_value()
    {
        $this->isGreaterThan(Money::createFromUnits(1000, $this->currency))
             ->shouldReturn(true);
    }

    public function it_isnt_greater_than_a_money_value_with_a_greater_value()
    {
        $this->isGreaterThan(Money::createFromUnits(1200, $this->currency))
             ->shouldReturn(false);
    }

    public function it_throws_when_constructed_with_floating_point_units()
    {
        $this->shouldThrow(new \InvalidArgumentException())
             ->duringCreateFromUnits(10.1, $this->currency);
    }

    public function it_has_a_factory_method_which_creates_from_value()
    {
        $money = $this::createFromValue(9.50, $this->currency);

        $money->getValue()->shouldReturn(9.50);
        $money->getCurrency()->shouldReturn($this->currency);
    }

    public function it_has_a_factory_method_which_creates_from_units()
    {
        $money = $this::createFromUnits(950, $this->currency);

        $money->getUnits()->shouldReturn(950);
        $money->getCurrency()->shouldReturn($this->currency);
    }

    public function it_returns_true_from_isSameCurrency_for_same_currencies()
    {
        $this->shouldBeSameCurrency($this->currency);
    }

    public function it_returns_false_from_isSameCurrency_for_different_currencies()
    {
        $this->shouldNotBeSameCurrency(new Currency('USD', 2));
    }

    /*
    public function it_initializes_with_zero_value()
    {
        $this->getValue()->shouldReturn(0.0);
    }

    public function it_set_value_via_constructor()
    {
        $this->beConstructedWith(22);

        $this->getValue()->shouldReturn(22.0);
    }

    public function it_returns_set_value()
    {
        $this->setValue(24.75);

        $this->getValue()->shouldReturn(24.75);
    }

    public function it_throws_if_doesnt_match_precision()
    {
        $this->beConstructedWith(0, 2);

        $this->shouldThrow(new IncorrectPrecisionException())
             ->duringSetValue(2.342);
    }

    public function it_works_with_other_precisions()
    {
        $this->beConstructedWith(0, 3);

        $this->setValue(1.234);

        $this->getValue()->shouldReturn(1.234);
    }

    public function it_throws_if_precision_is_negative()
    {
        $this->shouldThrow(new NegativePrecisionException())
             ->during('__construct', array(0, -1));
    }

    public function it_can_handle_amount_of_one_point_one()
    {
        // This was causing an error, I think it must have
        // been some sort of floating point error
        $this->setValue(1.1);
    }

    public function it_can_handle_amount_of_69_point_1()
    {
        $this->setValue(69.1);
    }

    public function it_converts_to_formatted_string()
    {
        $this->setValue(2.15);

        $this->__toString()->shouldReturn('2.15');
    }
    */
}
