<?php

namespace Sourcebox\HaveIBeenPwnedCLI\Console;

use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputDefinition;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    public $application;

    public function setUp()
    {
        $this->application = new Application();
    }

    public function testGetDefinition()
    {
        $this->assertInstanceOf(InputDefinition::class, $this->application->getDefinition());
    }

    public function testGetCommandName()
    {
        $class = new \ReflectionClass($this->application);
        $method = $class->getMethod('getCommandName');
        $method->setAccessible(true);

        $this->assertEquals('check:csv', $method->invokeArgs($this->application, [$this->createMock(Input::class)]));
    }
}
