<?php

namespace RebelCode\Modular\FuncTest\Factory;

use Xpmock\TestCase;
use RebelCode\Modular\Factory\AbstractDelegatingFactory;

/**
 * Tests {@see RebelCode\Modular\Factory\AbstractDelegatingFactory}.
 *
 * @since [*next-version*]
 */
class AbstractDelegatingFactoryTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\Modular\\Factory\\AbstractDelegatingFactory';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return AbstractDelegatingFactory
     */
    public function createInstance($delegate = null, $serviceId = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->_getGenericFactory($delegate)
                ->_getModuleServiceId($serviceId)
                ->_createModuleFactoryException()
                ->_createCouldNotMakeModuleException()
                ->new();

        return $mock;
    }

    public function createFactory()
    {
        $mock = $this->mock('Dhii\\Factory\\FactoryInterface')
                ->make()
                ->new();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME, $subject, 'A valid instance of the test subject could not be created'
        );
    }

    /**
     * Tests that the delegate factory is being instructed to make correctly.
     *
     * @since [*next-version*]
     */
    public function testMakeModule()
    {
        $key = uniqid('module-');
        $config = array('load' => function () {});
        $delegate = $this->createFactory();
        $delegate->mock()
                ->make(array($key, $config), $this->exactly(1));
        $subject = $this->createInstance($delegate, $key);
        $_subject = $this->reflect($subject);

        $_subject->_makeModule($config);
    }
}
