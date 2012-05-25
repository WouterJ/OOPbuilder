<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Builder;

use OOPbuilder\Helper;

/**
 * Build a method
 */
class MethodBuilder implements BuilderInterface
{
    protected $name;
    protected $access;
    protected $arguments = array();
    protected $code;

	/**
	 * Constructor.
	 *
	 * @param string $name	 The name of the method
	 * @param string $access Optional The access of the method, can be public(default), protected, or private
	 */
    public function __construct($name, $access = 'public')
    {
		$this->name = preg_replace_callback('/^[A-Z]/', function($match) {
			return strtolower($match[0]);
		}, $name);

        $this->access = (Helper::is_access($access)
                            ? $access
                            : 'public'
                        );
    }

	/**
	 * Add an argument to the method.
	 *
	 * @param string $name	  The name of the argument
	 * @param string $default Optional The default value of the argument
	 */
    public function addArgument($name, $default = null)
    {
        $this->arguments[$name] = $default;
    }

    /**
	 * Set the internal default code of the method.
	 *
	 * @param string $code The code of the method
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Create the method.
     *
     * @return string The source of the method
     */
    public function build()
    {
        $method = "\t".$this->access.' function '.$this->name.'('.$this->generateArguments().")\n\t{";
        if (null !== $this->code) {
            $method .= "\n\t\t".$this->code;
        }

        return $method."\n\t}";
    }

	/**
	 * Build the correct syntax for the arguments.
	 *
	 * @access protected
	 */
    protected function generateArguments()
    {
        $args = '';
        foreach ($this->arguments as $name => $defaultValue) {
            $args .= '$'.$name.($defaultValue !== null
                                ? ' = '.Helper::parseValue($defaultValue)
                                : ''
                             ).', ';
        }
        if (substr($args, -2) == ', ') {
            $args = substr($args, 0, -2);
        }

        return $args;
    }
}
