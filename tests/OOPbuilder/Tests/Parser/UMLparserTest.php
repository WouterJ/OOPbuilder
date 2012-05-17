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

	public function testEmptyClass()
	{
		$uml = <<<EOT
FooClass
EOT;
        $data = $this->parser->parse($uml);

        $this->assertCount(1, $data);
        $data = $data[0];
        $this->assertEquals('class', $data['type']);
        $this->assertEquals('FooClass', $data['name']);
        $this->assertEmpty($data['properties']);
        $this->assertEmpty($data['methods']);
	}

    public function testEmptyInterface()
    {
        $uml = <<<EOT
<<FooInterface>>
EOT;
        $data = $this->parser->parse($uml);

        $this->assertCount(1, $data);
        $data = $data[0];
        $this->assertEquals('interface', $data['type']);
        $this->assertEquals('FooInterface', $data['name']);
        $this->assertArrayNotHasKey('properties', $data);
        $this->assertEmpty($data['methods']);
    }
}
