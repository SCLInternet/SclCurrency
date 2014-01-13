<?php

namespace spec\SCL\Currency\Money\Formatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AsciiContextSpec extends ObjectBehavior
{
    public function it_is_formatter_context()
    {
        $this->shouldHaveType('SCL\Currency\Money\Formatter\FormatterContext');
    }

    public function it_returns_html_currency_symbol_from_config()
    {
        $config = array('symbol_ascii' => 'SYM');

        $this->getCurrencySymbol($config)->shouldReturn('SYM');
    }
}
