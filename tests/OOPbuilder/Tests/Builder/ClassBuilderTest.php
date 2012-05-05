<?php

namespace OOPbuilder\Tests\Builder;

use OOPbuilder\Builder\ClassBuilder;
use OOPbuilder\Builder\MethodBuilder;
use OOPbuilder\Builder\PropertyBuilder;

class ClassBuilderTest extends \PHPUnit_Framework_TestCase
{
	public function testInstance()
	{
		$this->assertInstanceOf('OOPbuilder\Builder\BuilderInterface', new Classbuilder('foobar'));
	}

	public function testClassName()
	{
		$builder = new ClassBuilder('HelloWorld');
		$this->assertContains('HelloWorld', $builder->build());

		$builder = new ClassBuilder('helloWorld');
		$this->assertContains('HelloWorld', $builder->build());
	}

	public function testEmptyClass()
	{
		$builder = new ClassBuilder('Foobar');

		$this->assertEquals('class Foobar {}', $builder->build());
	}

	public function testClassWithProperties()
	{
		$props = array();
		$props[] = new PropertyBuilder('foo', 'protected', 'Lorem ipsum');
		$props[] = new PropertyBuilder('bar');
		$props[] = new PropertyBuilder('baz');

		$builder = new ClassBuilder('HelloWorld');
		foreach ($props as $prop) {
			$builder->addProperty($prop);
		}
		$class = $builder->build();

		$this->assertContains('protected $foo = \'Lorem ipsum\';', $class);
		$this->assertContains('public $bar;', $class);
		$this->assertContains('public $baz;', $class);
	}

	public function testClassWithMethods()
	{
		$methods = array();
		$methods[] = new MethodBuilder('goodbye');
		$methodBuilder = new MethodBuilder('sayHello');
		$methodBuilder->addArgument('name');
		$methods[] = $methodBuilder;

		$builder = new ClassBuilder('HelloWorld');
		foreach ($methods as $method) {
			$builder->addMethod($method);
		}
		$class = $builder->build();

		$this->assertContains('public function goodbye()', $class);
		$this->assertContains('public function sayHello($name)', $class);
	}

	public function testClassWithPropertiesAndMethods()
	{
		$prop = new PropertyBuilder('name', 'protected');

		$method= new MethodBuilder('sayHello');
		$method->setCode('return "Hello ".$this->name;');

		$builder = new ClassBuilder('User');
		$builder->addProperty($prop);
		$builder->addMethod($method);

		$class = $builder->build();

		$this->assertContains('	protected $name;', $class);
		$this->assertContains('	public function sayHello()', $class);
	}
}
