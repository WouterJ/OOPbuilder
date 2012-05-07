<?php

namespace OOPbuilder\Tests\Parser;

use OOPbuilder\Parser\UMLparser;

class UMLparserTest extends \PHPUnit_Framework_TestCase
{
	protected $parser;

	public function setUp()
	{
		$this->parser = new UMLparser();
	}

	public function testClassName()
	{
		$uml = <<<EOT
<<SomeInterface>>
  + anotherMethod(someParam, otherFoo = null, bar = true)
  - privateMethod()

ClassName
  # propertyName
  - propertyWithValue = true
  + method()

AnotherClass : ClassName
  + anotherMethod(someParam, otherFoo = null, bar = true)
  - privateMethod()
  # protectedMethod(param)
EOT;
		var_dump($this->parser->parse($uml));
	}
}
