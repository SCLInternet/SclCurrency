<?php

namespace SCL\Currency\Factory;

abstract class AbstractFactoryFacade
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var AbstractFactoryFacade
     */
    protected static $staticFactory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public static function setStaticFactory(self $factory)
    {
        static::$staticFactory = $factory;
    }

    /**
     * Only really intended for testing.
     */
    public static function clearStaticFactory()
    {
        static::$staticFactory = null;
    }

    /**
     * @return Factory
     */
    public static function getStaticFactory()
    {
        static::assertStaticFactoryHasBeenCreated();

        return static::$staticFactory;
    }

    protected static function assertStaticFactoryHasBeenCreated()
    {
        if (!static::$staticFactory) {
            static::$staticFactory = static::createDefaultInstance();
        }
    }

    /**
     * @return AbstractFactoryFacade
     */
    public static function createDetaultInstance()
    {
        return new static();
    }
}
