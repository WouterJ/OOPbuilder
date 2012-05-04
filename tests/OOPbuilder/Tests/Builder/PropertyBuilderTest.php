<?php

namespace OOPbuilder\Tests\Builder;

use OOPbuilder\Builder\PropertyBuilder;

class PropertyBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testPropertyName()
    {
        $builder = new PropertyBuilder('propName');
        $this->assertContains('$propName', $builder->build());

        $builder = new PropertyBuilder('foobar');
        $this->assertContains('$foobar', $builder->build());
    }

    public function testPropertyAccess()
    {
        $builder = new PropertyBuilder('foobar', 'protected');
        $this->assertRegExp('/^protected\s/', $builder->build());

        $builder = new PropertyBuilder('foobar', 'private');
        $this->assertRegExp('/^private\s/', $builder->build());
    }

    public function testDefaultValues()
    {
        $builder = new PropertyBuilder('foobar', 'public', "''");
        $this->assertRegExp("/[^']'';$/", $builder->build());

        $builder = new PropertyBuilder('foobar', 'public', 'helloWorld');
        $this->assertRegExp("/'helloWorld';$/", $builder->build());

        $builder = new PropertyBuilder('foobar', 'public', 'array()');
        $this->assertRegExp("/array\(\);$/", $builder->build());

        $builder = new PropertyBuilder('foobar', 'public', 'new Foo');
        $this->assertRegExp("/new Foo;$/", $builder->build());

        $builder = new PropertyBuilder('foobar', 'public', '130');
        $this->assertRegExp("/130;$/", $builder->build());

        $builder = new PropertyBuilder('foobar', 'public', 'true');
        $this->assertRegExp("/true;$/", $builder->build());
    }

    public function testPropertyWithDefaultValues()
    {
        $builder = new PropertyBuilder('foo');

        $this->assertEquals('public $foo;', $builder->build());
    }
}
