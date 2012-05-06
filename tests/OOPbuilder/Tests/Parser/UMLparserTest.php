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
ClassName
  + method()

AnotherClass
  + anotherMethod(someParam, otherFoo = null, bar = true)
EOT;
		var_dump($this->parser->parse($uml));
	}
}
