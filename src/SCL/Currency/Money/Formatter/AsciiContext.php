<?php

namespace SCL\Currency\Money\Formatter;

class AsciiContext implements FormatterContext
{
    public function getCurrencySymbol(array $config)
    {
        return $config['symbol_ascii'];
    }
}
