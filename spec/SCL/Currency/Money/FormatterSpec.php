<?php

namespace spec\SCL\Currency\Money;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SCL\Currency\Money;
use SCL\Currency\Currency;
use SCL\Currency\Exception\UnknownCurrencyException;

class FormatterSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(array(
            'GBP' => array(
                'name'            => 'Great British Pounds',
                'precision'       => '2',
                'separator'       => '.',
                'symbol_ascii'    => '£',
                'symbol_html'     => '&pound;',
                'symbol_position' => 'left',
            ),
            'BTC' => array(
                'name'            => 'BitCoin',
                'precision'       => '8',
                'separator'       => '.',
                'symbol_ascii'    => 'BTC',
                'symbol_html'     => 'BTC',
                'symbol_position' => 'right',
            ),
        ));
    }

    public function it_throws_if_currency_is_unknown_for_formatAsNumber()
    {
        $this->shouldThrow(new UnknownCurrencyException('UNK'))
             ->duringFormatAsNumber($this->createMoney(0, 'UNK'));
    }

    public function it_formats_currency_to_number()
    {
        $this->formatAsNumber($this->createMoney(100, 'GBP'))
             ->shouldReturn(1.0);

        $this->formatAsNumber($this->createMoney(567000000, 'BTC'))
             ->shouldReturn(5.67);
    }

    public function it_throws_if_currency_is_unknown_for_formatAsString()
    {
        $this->shouldThrow(new UnknownCurrencyException('UNK'))
             ->duringFormatAsString($this->createMoney(0, 'UNK'));
    }

    public function it_formats_currency_to_string()
    {
        $this->formatAsString($this->createMoney(100, 'GBP'))
             ->shouldReturn('£ 1.00');

        $this->formatAsString($this->createMoney(567000000, 'BTC'))
             ->shouldReturn('5.67000000 BTC');
    }

    public function it_creates_default_version_with_config()
    {
        // GBP is in the config so this will fail if it's not loaded
        $this::createDefaultInstance()->formatAsNumber($this->createMoney(0, 'GBP'));
    }

    /**
     * @param int    $amount
     * @param string $currency
     *
     * @return Money
     */
    private function createMoney($amount, $currency)
    {
        return new Money($amount, new Currency($currency));
    }
}
