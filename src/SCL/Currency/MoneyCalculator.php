<?php

namespace SCL\Currency;

use SCL\Currency\Money;
use SCL\Currency\Exception\CurrencyMismatchException;

class MoneyCalculator
{
    /**
     * @var Money
     */
    private $valueA;

    /**
     * @var Money
     */
    private $valueB;

    /**
     * @return Money
     */
    public function add(Money $value, Money $addend)
    {
        $this->valueA = $value;
        $this->valueB = $addend;

        return $this->performOperationOn2Currencies(
            function ($value, $addend) {
                return $value + $addend;
            }
        );
    }

    /**
     * @return Money
     */
    public function subtract(Money $value, Money $subtrahend)
    {
        $this->valueA = $value;
        $this->valueB = $subtrahend;

        return $this->performOperationOn2Currencies(
            function ($value, $subtrahend) {
                return $value - $subtrahend;
            }
        );
    }

    /**
     * @param  callable $operation Signature: int function(int $a, int $b)
     *
     * @return Money
     */
    private function performOperationOn2Currencies($operation)
    {
        $this->assertCurrenciesMatch();

        return new Money(
            $operation($this->valueA->getValue(), $this->valueB->getValue()),
            $this->valueA->getCurrency()
        );
    }

    /**
     * @return CurrencyMismatchException
     */
    public function assertCurrenciesMatch()
    {
        if (!$this->valueA->isSameCurrency($this->valueB->getCurrency())) {
            throw new CurrencyMismatchException();
        }
    }
}
