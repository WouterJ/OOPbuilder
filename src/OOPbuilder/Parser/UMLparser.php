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
            $info[] = $this->parseClass(implode("\n", $class));
        }

		return $info;
	}

	public function parseClass($str)
	{
		$class = array('type' => 'class');
		$i = -1;

		foreach (preg_split('/\n/', $str) as $line) {
			if ($line !== 0 && empty($line)) {
				continue;
			}

			if (substr($line, 0, 2) !== '  ') {
				$class[++$i] = array(
					'name' => $line,
					'methods' => array(),
				);
			}
			elseif (substr($line, 0, 2) === '  ') {
				$class[$i]['methods'][] = $this->parseMethod(substr($line, 2));
			}
			else {
				continue;
			}
		}

		return $class;
	}

	public function parseMethod($str)
	{
		$property = array(
			'name' => '',
			'access' => $this->parseAccess(substr($str, 0, 1)),
		);
		preg_match('/(?<=\s).*?(?=\()/', $str, $name);
		$property['name'] = $name[0];

        if (preg_match('/\((.+?)\)$/', $str, $args)) {
            $property['arguments'] = array();

            $arguments = explode(', ', $args[1]);
            foreach ($arguments as $arg) {
                @list($argName, $argValue) = explode('=', $arg);
                $property['arguments'][] = array(
                    'name' => trim($argName),
                    'value' => ($argValue !== 0 && !empty($argValue)
                                    ? Helper::parseValue(trim($argValue))
                                    : null
                               ),
                );
            }
        }

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
