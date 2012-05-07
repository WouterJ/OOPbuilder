<?php

namespace OOPbuilder\Parser;

use OOPbuilder\Helper;

class UMLparser implements ParserInterface
{
	public function parse($data)
	{
		$info = array();
        $parts = array(
            'classes' => array(),
            'interfaces' => array(),
        );
        $i = -1;

		foreach (preg_split('/((\r?\n)|(\n?\r))/', $data) as $line) {
			if ($line !== 0 && empty($line)) {
				continue;
			}

			if (substr($line, 0, 2) !== '  ') {
                if (substr($line, 0, 2) == '<<') {
                    $parts['interfaces'][++$i] = array($line);
                }
                else {
                    $parts['classes'][++$i] = array($line);
                }
            }
            else {
                if (isset($parts['classes'][$i])) {
                    $parts['classes'][$i][] = $line;
                }
                else {
                    $parts['interfaces'][$i][] = $line;
                }
            }
        }

        foreach ($parts['classes'] as $class) {
            $info[] = $this->parseClass($class);
        }

		return $info;
	}

	public function parseClass($data)
	{
        $class = array(
            'type' => 'class',
            'name' => '',
            'properties' => array(),
            'methods' => array(),
        );

		foreach ($data as $line) {
			if ($line !== 0 && empty($line)) {
				continue;
			}

			if (substr($line, 0, 2) !== '  ') {
				$class['name'] = $line;
                if (count($children = explode('::', $line)) > 1) {
                    $class['name'] = trim($children[0]);
                    $class['childOf'] = trim($children[1]);
                }
			}
			elseif (substr($line, 0, 2) === '  ') {
                if (substr(trim($line), -1) === ')') {
                    $class['methods'][] = $this->parseMethod(substr($line, 2));
                }
                else {
                    $class['properties'][] = $this->parseProperty(substr($line, 2));
                }
			}
			else {
				continue;
			}
		}

		return $class;
	}

    public function parseProperty($str)
    {
        $property = array(
            'access' => $this->parseAccess(substr($str, 0, 1)),
        );

        $value = explode('=', $str);
        $property['name'] = substr(trim($value[0]), 2);
        if (count($value) > 1) {
            $property['value'] = trim(Helper::parseValue(trim($value[1])));
        }

        return $property;
    }

	public function parseMethod($str)
	{
		$method = array(
			'access' => $this->parseAccess(substr($str, 0, 1)),
		);
		preg_match('/(?<=\s).*?(?=\()/', $str, $name);
		$method['name'] = $name[0];

        if (preg_match('/\((.+?)\)$/', $str, $args)) {
            $method['arguments'] = $this->parseArguments($args[1]);
        }

		return $method;
	}

	public function parseArguments($args)
    {
        $argumentsList = array();

        $arguments = explode(', ', $args);

        foreach ($arguments as $arg) {
            @list($argName, $argValue) = explode('=', $arg);
            $argumentsList[] = array(
                'name' => trim($argName),
                'value' => ($argValue !== 0 && !empty($argValue)
                                ? Helper::parseValue(trim($argValue))
                                : null
                           ),
            );
        }

        return $argumentsList;
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
                    [0] => Array (
                        [name] => 'foo',
                        [value] => 'some default foovalue',
                    ),
                    [1] => Array (
                        ...
                    ),
                    ...
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
