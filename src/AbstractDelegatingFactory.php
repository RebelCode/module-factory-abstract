<?php

namespace RebelCode\Modular\Factory;

use Dhii\Factory\FactoryInterface;
use Dhii\Modular\Factory\ModuleFactoryExceptionInterface;
use Dhii\Modular\Factory\CouldNotMakeModuleExceptionInterface;
use Dhii\I18n\StringTranslatorAwareTrait;
use Dhii\I18n\StringTranslatorConsumingTrait;
use Exception;

/**
 * A module factory that can delegate the making of modules to a
 * general-purpose factory.
 *
 * @since [*next-version*]
 */
abstract class AbstractDelegatingFactory extends AbstractFactory
{
    /*
     * @since [*next-version*]
     */
    use StringTranslatorAwareTrait;

    /*
     * @since [*next-version*]
     */
    use StringTranslatorConsumingTrait;

    /**
     * The generic factory.
     *
     * @since [*next-version*]
     *
     * @var FactoryInterface
     */
    protected $genericFactory;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _makeModule($config)
    {
        if (!($factory = $this->_getGenericFactory())) {
            throw $this->_createCouldNotMakeModuleException($this->__('Delegate factory is not set'), null, $config, $e);
        }
        if (!($key = $this->_getModuleServiceId($config))) {
            throw $this->_createCouldNotMakeModuleException($this->__('Service key could not be retrieved'), null, $config, $e);
        }

        try {
            $module = $factory->make($key, $config);
        } catch (Exception $e) {
            throw $this->_createCouldNotMakeModuleException($this->__('Delegate factory raised an exception'), $key, $config, $e);
        }

        return $module;
    }

    /**
     * Retrieves the generic factory that making will be delegated to.
     *
     * @since [*next-version*]
     *
     * @return FactoryInterface The factory.
     */
    protected function _getGenericFactory()
    {
        return $this->genericFactory;
    }

    /**
     * Assigns the generic factory to delegate making to.
     *
     * @since [*next-version*]
     *
     * @param FactoryInterfacee $factory The factory.
     *
     * @return $this
     */
    protected function _setGenericFactory(FactoryInterfacee $factory)
    {
        $this->genericFactory = $factory;

        return $this;
    }

    /**
     * Deduces the service ID to pass to the generic factory for module creation.
     *
     * @since [*next-version*]
     *
     * @param array $config The configuration being used for module creation.
     *
     * @return string The service ID of the module service.
     */
    abstract protected function _getModuleServiceId($config = array());

    /**
     * Creates a new module factory exception.
     *
     * @since [*next-version*]
     *
     * @param string    $message The error message.
     * @param Exception $inner   The inner exception, if any.
     *
     * @return ModuleFactoryExceptionInterface The new exception.
     */
    abstract protected function _createModuleFactoryException($message, Exception $inner = null);

    /**
     * Creates a new "could not make new module" exception.
     *
     * @since [*next-version*]
     *
     * @param string         $message      The error message.
     * @param string|null    $moduleKey    The service key used to identify the module service, if any.
     * @param array|null     $moduleConfig The configuration used to attempt module creation, if any.
     * @param Exception|null $inner        The inner exception, if any.
     *
     * @return CouldNotMakeModuleExceptionInterface The new exception.
     */
    abstract protected function _createCouldNotMakeModuleException($message, $moduleKey = null, $moduleConfig = null, Exception $inner = null);
}
