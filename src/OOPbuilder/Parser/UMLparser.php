<?php

namespace OOPbuilder\Parser;

use OOPbuilder\Helper;

class UMLparser implements ParserInterface
{
	public function parse($data)
	{
		$info = array();

		// parsing
		
		return $info;
	}

	public function getClasses($str)
	{
		$classes = array();
		$i = -1;

		foreach (preg_split('/((\r?\n)|(\n?\r))/', $str) as $line) {
			if ($line !== 0 && empty($line)) {
				continue;
			}

			if (substr($line, 0, 2) !== '  ') {
				$classes[++$i] = array(
					'name' => $line,
					'methods' => array(),
				);
			}
			elseif (substr($line, 0, 2) === '  ') {
				$classes[$i]['methods'][] = $this->parseMethod(substr($line, 2));
			}
			else {
				continue;
			}
		}
		return $classes;
	}

	public function parseMethod($str)
	{
		$property = array(
			'name' => '',
			'access' => $this->parseAccess(substr($str, 0, 1)),
		);
		preg_match('/(?<=\s).*?(?=\()/', $str, $name);
		$property['name'] = $name[0];

		return $property;
	}

	public function parseArguments($str)
	{
	}

	public function parseAccess($str)
	{
		$umlAccess = array(
			'+' => 'public',
			'#' => 'protected',
			'-' => 'private',
		);

		if (isset($umlAccess[$str])) {
			return $umlAccess[$str];
		}
		else {
			return (Helper::is_access($str)
						? $str
						: 'public'
				   );
		}
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
 */
