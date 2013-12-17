<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Factory\MoneyFactory;
use SCL\Currency\Currency;
use SCL\Currency\Money;
use SCL\Currency\Factory;
use SCL\Currency\Factory\TaxedPriceFactory as TaxedPriceFactoryInterface;
use SCL\Currency\TaxedPrice;

class TaxedPriceFactorySpec extends ObjectBehavior
{
    private $priceFactory;

    public function letgo()
    {
        $this::clearStaticFactory();
    }

    public function let(TaxedPriceFactoryInterface $priceFactory)
    {
        $this->priceFactory = $priceFactory;

        $this->beConstructedWith($this->priceFactory);
    }

    /*
     * createTaxedPrice()
     */

    public function it_creates_price_using_given_objects()
    {
        $amount = $this->createMockMoney(10);
        $tax    = $this->createMockMoney(2);

        $this->priceFactory
             ->createWithObjects($amount, $tax)
             ->shouldBeCalled();

        $this->createTaxedPrice($amount, $tax);
    }

    public function it_returns_created_price_using_given_objects()
    {
        $amount = $this->createMockMoney(10);
        $tax    = $this->createMockMoney(2);
        $price  = new TaxedPrice($amount, $tax);

        $this->priceFactory
             ->createWithObjects(Argument::any(), Argument::any())
             ->willReturn($price);

        $this->createTaxedPrice($amount, $tax)->shouldReturn($price);
    }

    public function it_create_price_using_values()
    {
        $amount   = 10;
        $tax      = 2;
        $currency = 'GBP';

        $this->priceFactory
             ->createWithValues($amount, $tax, $currency)
             ->shouldBeCalled();

        $this->createTaxedPrice($amount, $tax, $currency);
    }

    public function it_returns_created_price_using_values()
    {
        $price = new TaxedPrice(
            $this->createMockMoney(10),
            $this->createMockMoney(2)
        );

        $this->priceFactory
             ->createWithValues(Argument::any(), Argument::any(), Argument::any())
             ->willReturn($price);

        $this->createTaxedPrice(10, 2, 'GBP')->shouldReturn($price);
    }

    public function it_creates_price_using_default_currency()
    {
        $amount   = 10;
        $tax      = 2;

        $this->priceFactory
             ->createWithValuesAndDefaultCurrency($amount, $tax)
             ->shouldBeCalled();

        $this->createTaxedPrice($amount, $tax);
    }

    public function it_returns_created_price_using_default_currency()
    {
        $price = new TaxedPrice(
            $this->createMockMoney(10),
            $this->createMockMoney(2)
        );

        $this->priceFactory
             ->createWithValuesAndDefaultCurrency(Argument::any(), Argument::any())
             ->willReturn($price);

        $this->createTaxedPrice(10, 2)->shouldReturn($price);
    }

    /*
     * createDefaultFactory()
     */

    public function it_create_a_default_instance_of_Factory()
    {
        $this::createDefaultInstance()->shouldReturnAnInstanceOf('SCL\Currency\TaxedPriceFactory');
    }

    public function it_creates_a_default_instance_with_some_config()
    {
        $factory = $this::createDefaultInstance();

        // With throw if currency GBP is no found so proves the config has been read
        $factory->createTaxedPrice(10, 2, 'GBP')->shouldReturnAnInstanceOf('SCL\Currency\TaxedPrice');
    }

    /*
     * static methods
     */

    public function it_proxies_static_create_price_calls_to_an_instance_of_factory(Factory $factory)
    {
        $this::setStaticFactory($factory);

        $factory->createTaxedPrice(10, 2, 'GBP')->shouldBeCalled();

        $this::staticCreateTaxedPrice(10, 2, 'GBP');
    }

    public function it_returns_statically_created_price(Factory $factory, TaxedPrice $price)
    {
        $this::setStaticFactory($factory);

        $factory->createTaxedPrice(Argument::any(), Argument::any(), Argument::any())->willReturn($price);

        $this::staticCreateTaxedPrice(0, 0, 'GBP')->shouldReturn($price);
    }

    public function it_returns_static_factory(Factory $factory)
    {
        $this::setStaticFactory($factory);

        $this::getStaticFactory()->shouldReturn($factory);
    }

    public function it_creates_default_static_factory_if_one_is_not_set_during_staticCreateTaxeddePrice()
    {
        // With throw if currency GBP is no found so proves the config has been read
        $this::staticCreateTaxedPrice(10, 10, 'GBP')->shouldReturnAnInstanceOf('SCL\Currency\TaxedPrice');
    }

    public function it_creates_default_static_factory_if_one_is_not_set_during_getStaticFactory()
    {
        $this::getStaticFactory()->shouldReturnAnInstanceOf('SCL\Currency\TaxedPriceFactory');
    }


    private function createMockMoney($amount = 0)
    {
        return new Money($amount, new Currency('GBP'));
    }
}
