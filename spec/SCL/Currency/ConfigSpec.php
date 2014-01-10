<?php

namespace spec\SCL\Currency;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigSpec extends ObjectBehavior
{
    public function it_returns_default_config_file_path()
    {
        $defaultConfigPath = realpath(__DIR__ . '/../../../config/currencies.config.php');

        $this::getDefaultConfigPath()->shouldReturn($defaultConfigPath);
    }

    public function it_returns_default_config()
    {
        $defaultConfigPath = realpath(__DIR__ . '/../../../config/currencies.config.php');

        $defaultConfig = include($defaultConfigPath);

        $this::getDefaultConfig()->shouldReturn($defaultConfig);
    }
}
