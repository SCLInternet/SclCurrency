<?php

namespace SCL\Currency;

/**
 * Decorator which exposes the contents of a CurrencyValue object.
 */
class RawCurrencyValue extends CurrencyValue
{
    /**
     * @var CurrencyValue
     */
    private $instance;

    public function __construct(CurrencyValue $value)
    {
        $this->instance = $value;
    }

    public function getRawValue()
    {
        return $this->instance->value;
    }

    /**
     * @param  int $value
     */
    public function setRawValue($value)
    {
        $this->instance->value = (int) $value;
    }

    public function getPrecision()
    {
        return $this->instance->precision;
    }

    public function getValue()
    {
        return $this->instance->getValue();
    }

    public function setValue($value)
    {
        $this->instance->setValue($value);
    }

    public function __toString()
    {
        return $this->instance->__toString();
    }
}
