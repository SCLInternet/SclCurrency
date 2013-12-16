<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurrencySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('GBP');
    }

    public function it_stores_the_code()
    {
        $this->getCode()->shouldReturn('GBP');
    }
}
