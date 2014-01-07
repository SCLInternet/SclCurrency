<?php

namespace SCL\Currency\Exception;

class PrecisionMismatchException extends \RuntimeException
{
    /**
     * @param string $code
     * @param int    $precision1
     * @param int    $precision2
     *
     * @return PrecisionMismatchException
     */
    public static function create($code, $precision1, $precision2)
    {
        return new self("2 currencies with code $code have different precisions $precision1 != $precision2.");
    }
}
