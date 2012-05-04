<?php

namespace OOPbuilder\Tests\Builder;

use OOPbuilder\Builder\MethodBuilder;

class MethodBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodName()
    {
        $method = new MethodBuilder('foobar');

        $this->assertContains('foobar', $method->build());
    }

    public function testMethodAccess()
    {
        $method = new MethodBuilder('foobar', 'public');
        $this->assertContains('public', $method->build());

        $method = new MethodBuilder('foobar', 'protected');
        $this->assertContains('protected', $method->build());

        // wrong value should result in public
        $method = new MethodBuilder('foobar', 'fooAccess');
        $this->assertContains('public', $method->build());
    }

    public function testMethodArguments()
    {
        $method = new MethodBuilder('foobar');
        $method->addArgument('baz');

        $this->assertContains('($baz)', $method->build());

        $method->addArgument('lorem');

        $this->assertContains('($baz, $lorem)', $method->build());
    }

    public function testMethodArgumentsWithDefaultValue()
    {
        $method = new MethodBuilder('foobar');
        $method->addArgument('baz', 'hello world');

        $this->assertContains('($baz = \'hello world\')', $method->build());
    }

    public function testMethodCode()
    {
        $method = new MethodBuilder('foobar');
        $method->setCode("return 'Hello World';");

        $this->assertContains("return 'Hello World';", $method->build());
    }
}
