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

    public function testClassMethods()
    {
        $uml = <<<EOT
FooClass
  + barMethod()
  - fooMethod(arg1)
  # protectedMethod(foo = 'bar')
EOT;
        $data = $this->parser->parse($uml);

        $this->assertCount(1, $data);
        $data = $data[0];
        $this->assertCount(3, $data['methods']);

        $this->assertEquals('barMethod', $data['methods'][0]['name']);
        $this->assertEquals('public', $data['methods'][0]['access']);
        $this->assertCount(0, $data['methods'][0]['arguments']);

        $this->assertEquals('fooMethod', $data['methods'][1]['name']);
        $this->assertEquals('private', $data['methods'][1]['access']);
        $this->assertCount(1, $data['methods'][1]['arguments']);
        $this->assertSame(array(0 => array('name' => 'arg1', 'value' => null)), $data['methods'][1]['arguments']);

        $this->assertEquals('protectedMethod', $data['methods'][2]['name']);
        $this->assertEquals('protected', $data['methods'][2]['access']);
        $this->assertCount(1, $data['methods'][2]['arguments']);
        $this->assertSame(array(0 => array('name' => 'foo', 'value' => '\'bar\'')), $data['methods'][2]['arguments']);
    }
}
