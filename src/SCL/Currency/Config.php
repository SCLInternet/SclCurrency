<?php

namespace SCL\Currency;

class Config
{
    /**
     * @return string
     */
    public static function getDefaultConfigPath()
    {
        return realpath(__DIR__ . '/../../../config/currencies.config.php');
    }

    /**
     * @return array
     */
    public static function getDefaultConfig()
    {
        return include self::getDefaultConfigPath();
    }
}
