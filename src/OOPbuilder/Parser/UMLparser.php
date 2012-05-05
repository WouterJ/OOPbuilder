<?php

namespace OOPbuilder\Parser;

class UMLparser implements ParserInterface
{
	public function parse($data)
	{
		$info = array();
	}
}

/*

Array (
	[0] => Array (
		[type] => 'class',
		[name] => 'nameOfTheClass',
		[childOf] => 'someInterfaceOrClass',
		[properties] => Array (
			[0] => Array (
				[name] => 'baz',
				[access] => 'protected',
				[value] => 'some default value',
			),
			[1] => Array (
				...
			),
			...
		),
		[methods] => Array (
			[0] => Array (
				[name] => 'someMethod',
				[access] => 'public',
				[arguments] => Array (
					[name] => 'foo',
					[value] => 'some default foovalue',
				),
			),
			[1] => Array (
				...
			),
			...
		)
	),
	[1] => Array (
		[type] => 'interface',
		[name] => 'nameOfTheClass',
		[childOf] => 'someInterface',
		[methods] => Array (
			...
		),
	),
	...
)
