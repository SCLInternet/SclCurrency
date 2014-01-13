<?php

namespace spec\SCL\Currency\Money;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\Exception\UnknownCurrencyException;
use SCL\Currency\Money\Formatter\FormatterContext;

class FormatterSpec extends ObjectBehavior
{
    private $config;

    /**
     * @var FormatterContext
     */
    private $context;

    public function let(FormatterContext $context)
    {
        $this->config = array(
            'GBP' => array(
                'name'            => 'Great British Pounds',
                'precision'       => '2',
                'symbol_ascii'    => '£',
                'symbol_html'     => '&pound;',
                'symbol_position' => 'left',
            ),
            'BTC' => array(
                'name'            => 'BitCoin',
                'precision'       => '8',
                'symbol_ascii'    => 'BTC',
                'symbol_html'     => 'BTC',
                'symbol_position' => 'right',
            ),
        );

        $this->context = $context;

        $this->beConstructedWith($this->config, $context);
    }

    public function it_is_a_money_formatter()
    {
        $this->shouldBeAnInstanceOf('SCL\Currency\Money\Formatter');
    }

    public function it_throws_if_currency_is_unknown_for_format()
    {
        $this->shouldThrow(new UnknownCurrencyException('UNK'))
             ->duringFormat($this->createMoney(0, 'UNK'));
    }

    public function it_fetches_currency_symbol_from_the_context()
    {
        $this->context
             ->getCurrencySymbol($this->config['GBP'])
             ->shouldBeCalled();

        $this->format($this->createMoney(100, 'GBP'));
    }

    public function it_formats_currency_to_string()
    {
        $this->context
             ->getCurrencySymbol($this->config['GBP'])
             ->willReturn('GBPSYM');

        $this->format($this->createMoney(100, 'GBP'))
             ->shouldReturn('GBPSYM 1.00');

        $this->context
             ->getCurrencySymbol($this->config['BTC'])
             ->willReturn('BTCSYM');

        $this->format($this->createMoney(567000000, 'BTC'))
             ->shouldReturn('5.67000000 BTCSYM');
    }

    public function it_creates_default_version_with_config()
    {
        $this->context
             ->getCurrencySymbol($this->config['GBP'])
             ->shouldBeCalled();

        // GBP is in the config so this will fail if it's not loaded
        $this::createDefaultInstance($this->context)
             ->format($this->createMoney(0, 'GBP'));
    }

    /**
     * @param int    $amount
     * @param string $currency
     *
     * @return Money
     */
    private function createMoney($amount, $currency) { $precision = isset($this->config[$currency]) ? $this->config[$currency]['precision'] : 2;
        return new Money($amount, new Currency($currency, $precision));
    }
}
