<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Currency;
use SCL\Currency\CurrencyFactory;

class CurrencyFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(array(
            'GBP' => array(
                'precision' => 2,
            ),
            'BTC' => array(
                'precision' => 8,
            ),
        ));
    }

    public function it_returns_instance_of_currency_from_create()
    {
        $this->create('GBP')->shouldReturnAnInstanceOf('SCL\Currency\Currency');
    }

    public function it_throws_if_create_is_called_with_unknown_currency_code()
    {
        $this->shouldThrow(new UnknownCurrencyException('UNK'))
             ->duringCreate('UNK');
    }

    public function it_sets_currency_code()
    {
        $this->create('GBP')->getCode()->shouldReturn('GBP');
        $this->create('BTC')->getCode()->shouldReturn('BTC');
    }

    public function it_sets_precision()
    {
        $this->create('GBP')->getPrecision()->shouldReturn(2);
        $this->create('BTC')->getPrecision()->shouldReturn(8);
    }

    public function it_gives_the_same_currency_for_same_code()
    {
        $currency = $this->create('GBP');

        $this->create('GBP')->shouldReturn($currency);
    }
}
