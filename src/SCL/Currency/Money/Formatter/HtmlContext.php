<?php

namespace SCL\Currency\Money\Formatter;

class HtmlContext implements FormatterContext
{
    public function getCurrencySymbol(array $config)
    {
        return $config['symbol_html'];
    }
}
