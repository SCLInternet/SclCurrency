<?php

namespace SCL\Currency;

class TaxRate
{
    /**
     * @var float
     */
    private $percentage;

    /**
     * @param float $percentage
     */
    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }
}
