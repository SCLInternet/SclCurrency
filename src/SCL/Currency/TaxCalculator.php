<?php

namespace SCL\Currency;

use SCL\Currency\CurrencyValue;
use SCL\Currency\RawCurrencyValue;
use SCL\Currency\TaxRate;

class TaxCalculator
{
    /**
     * @return CurrencyValue
     */
    public function calculateTaxAmount(CurrencyValue $amount, TaxRate $taxRate)
    {
        return $this->applyCalculationWithValueAndRate(
            $amount,
            $taxRate,
            function ($amount, $rate) {
                // @todo Find out what rounding function is required
                return $amount * ($rate / 100);
            }
        );
    }

    /**
     * @return CurrencyValue
     */
    public function extractAmount(CurrencyValue $amountIncTax, TaxRate $taxRate)
    {
        return $this->applyCalculationWithValueAndRate(
            $amountIncTax,
            $taxRate,
            function ($amount, $rate) {
                // @todo Find out what rounding function is required
                return ($amount / (100 + $rate)) * 100;
            }
        );
    }

    /**
     * @return CurrencyValue
     */
    public function extractTaxAmount(CurrencyValue $amountIncTax, TaxRate $taxRate)
    {
        return $this->applyCalculationWithValueAndRate(
            $amountIncTax,
            $taxRate,
            function ($amount, $rate) {
                // @todo Find out what rounding function is required
                return ($amount / (100 + $rate)) * $rate;
            }
        );
    }

    /**
     * @return float
     */
    public function calculateTaxRate(CurrencyValue $amount, CurrencyValue $taxAmount)
    {
        return $taxAmount->getValue() / ($amount->getValue() / 100);
    }

    /**
     * @param callable $calculation Signature: int function(int $value, float $rate)
     */
    private function applyCalculationWithValueAndRate(
        CurrencyValue $value,
        TaxRate $rate,
        $calculation
    ) {
        $rawValue = new RawCurrencyValue($value);
        $result   = new CurrencyValue(0, $rawValue->getPrecision());

        $this->setRawCurrencyValue(
            $result,
            $calculation($rawValue->getRawValue(), $rate->getPercentage())
        );

        return $result;
    }

    /**
     * @param CurrencyValue $value
     * @param int           $amount
     */
    private function setRawCurrencyValue(CurrencyValue $currencyValue, $rawValue)
    {
        $raw = new RawCurrencyValue($currencyValue);

        $raw->setRawValue($rawValue);
    }
}
