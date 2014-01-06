<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Currency;
use SCL\Currency\Money;
use SCL\Currency\MoneyFactory;
use SCL\Currency\TaxedPrice;

class TaxedPriceFactorySpec extends ObjectBehavior
{
    private $moneyFactory;

    public function let(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;

        $this->beConstructedWith($moneyFactory);
    }

    /*
     * createFromMoney()
     */

    public function it_returns_TaxedPrice_from_createFromMoney()
    {
        $this->createFromMoney($this->createMoney(0), $this->createMoney(0))
             ->shouldReturnAnInstanceOf('SCL\Currency\TaxedPrice');
    }

    public function it_sets_TaxedPrice_amount_in_createFromMoney()
    {
        $amount = $this->createMoney(5);

        $this->createFromMoney($amount, $this->createMoney(0))
             ->getAmount()
             ->shouldReturn($amount);
    }

    public function it_sets_TaxedPrice_tax_in_createFromMoney()
    {
        $tax = $this->createMoney(5);

        $this->createFromMoney($this->createMoney(0), $tax)
             ->getTax()
             ->shouldReturn($tax);
    }

    /*
     * createFromUnitsAndRate()
     */

    public function it_returns_calculated_price()
    {
        $amount = 50;

        $this->moneyFactory
             ->createFromUnits($amount)
             ->shouldBeCalled()
             ->willReturn(new Money($amount, new Currency('GBP', 2)));

        $price = $this->createFromUnitsAndRate($amount, 20);

        $price->getAmount()->getUnits()->shouldReturn($amount);
        $price->getTax()->getUnits()->shouldReturn(10);
    }

    /*
     * createDefaultFactory()
     */

    public function it_create_a_default_instance_of_Factory()
    {
        $this::createDefaultInstance()->shouldReturnAnInstanceOf('SCL\Currency\TaxedPriceFactory');
    }

    /*
    public function it_creates_a_default_instance_with_some_config()
    {
        $factory = $this::createDefaultInstance();

        // With throw if currency GBP is no found so proves the config has been read
        $factory->create(10, 2, 'GBP')->shouldReturnAnInstanceOf('SCL\Currency\TaxedPrice');
    }
    */

    private function createMoney($amount)
    {
        return new Money($amount, new Currency('GBP', 2));
    }
}
