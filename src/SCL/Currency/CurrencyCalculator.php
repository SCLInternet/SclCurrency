<?php

namespace SCL\Currency;

use SCL\Currency\CurrencyValue;
use SCL\Currency\Exception\PrecisionMismatchException;
use SCL\Currency\RawCurrencyValue;

class CurrencyCalculator
{
    /**
     * @var RawCurrencyValue
     */
    private $valueA;

    /**
     * @var RawCurrencyValue
     */
    private $valueB;

    /**
     * $a + $b
     *
     * @return CurrencyValue
     */
    public function add(CurrencyValue $a, CurrencyValue $b)
    {
        return $this->performOperationOnIntegerValues($a, $b, function ($a, $b) {
            return $a + $b;
        });
    }

    /**
     * $a - $b
     *
     * @return CurrencyValue
     */
    public function subtract(CurrencyValue $a, CurrencyValue $b)
    {
        return $this->performOperationOnIntegerValues($a, $b, function ($a, $b) {
            return $a - $b;
        });
    }

    /**
     * @param  CurrencyValue $a
     * @param  CurrencyValue $b
     * @param  callable      $operation
     */
    private function performOperationOnIntegerValues(
        CurrencyValue $a,
        CurrencyValue $b,
        $operation
    ) {
        $this->getRawAccess($a, $b);

        $this->ensurePrecisionsMatch();

        return $this->createResult($operation);
    }

    private function getRawAccess(CurrencyValue $a, CurrencyValue $b)
    {
        $this->valueA = new RawCurrencyValue($a);
        $this->valueB = new RawCurrencyValue($b);
    }

    private function ensurePrecisionsMatch()
    {
        if ($this->valueA->getPrecision() !== $this->valueB->getPrecision()) {
            throw new PrecisionMismatchException();
        }
    }

    private function createResult($operation)
    {
        $result = new CurrencyValue($this->valueA->getPrecision());
        $access = new RawCurrencyValue($result);

        $access->setRawValue($operation(
            $this->valueA->getRawValue(),
            $this->valueB->getRawValue()
        ));

        return $result;
    }
}
