<?php

namespace SCL\Currency\TaxedPrice;

use SCL\Currency\Money;
use SCL\Currency\TaxRate;

class Calculator
{
    /**
     * @return Money
     */
    public function calculateTaxAmount(Money $amount, TaxRate $rate)
    {
        return $this->applyCalculationWithValueAndRate(
            $amount,
            $rate,
            function ($amount, $rate) {
                // @todo Find out what rounding function is required
                return $amount * ($rate / 100);
            }
        );
    }

    /**
     * @return Money
     */
    public function extractAmount(Money $amountIncTax, TaxRate $rate)
    {
        return $this->applyCalculationWithValueAndRate(
            $amountIncTax,
            $rate,
            function ($amount, $rate) {
                // @todo Find out what rounding function is required
                return ($amount / (100 + $rate)) * 100;
            }
        );
    }

    /**
     * @return Money
     */
    public function extractTaxAmount(Money $amountIncTax, TaxRate $rate)
    {
        return $this->applyCalculationWithValueAndRate(
            $amountIncTax,
            $rate,
            function ($amount, $rate) {
                // @todo Find out what rounding function is required
                return ($amount / (100 + $rate)) * $rate;
            }
        );
    }

    /**
     * @return float
     */
    public function calculateTaxRate(Money $amount, Money $taxAmount)
    {
        return new TaxRate($taxAmount->getUnits() / ($amount->getUnits() / 100));
    }

    /**
     * @param callable $calculation Signature: int function(int $value, float $rate)
     */
    private function applyCalculationWithValueAndRate(
        Money $value,
        TaxRate $rate,
        $calculation
    ) {
        return new Money(
            intval(round($calculation($value->getUnits(), $rate->getPercentage()))),
            $value->getCurrency()
        );
    }
}
