<?php

namespace SCL\Currency;

class Currency
{
    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = (string) $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
