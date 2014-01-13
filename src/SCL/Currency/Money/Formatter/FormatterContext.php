<?php

namespace SCL\Currency\Money\Formatter;

interface FormatterContext
{
    /**
     * @return string
     */
    public function getCurrencySymbol(array $config);
}
