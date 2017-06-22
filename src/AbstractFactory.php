<?php

namespace RebelCode\Modular\Factory;

use RebelCode\Modular\Module\ModuleInterface;

/**
 * Common functionality for module factories.
 *
 * @since [*next-version*]
 */
abstract class AbstractFactory
{
    /**
     * Parameter-less constructor.
     *
     * Invoke this in actual constructor.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
    }

    /**
     * Creates a new module instance.
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface the new module
     */
    abstract protected function _makeModule();
}
