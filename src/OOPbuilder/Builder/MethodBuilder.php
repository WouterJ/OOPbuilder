<?php

namespace OOPbuilder\Builder;

use OOPbuilder\Helper;

class MethodBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $access;

    /**
     * @var array
     */
    protected $arguments = array();

    /**
     * @var string
     */
    protected $code;

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

    public function addArgument($name, $default = null)
    {
        $this->arguments[$name] = $default;
    }

    /**
     * Set the internal default code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Builds a single method
     *
     * @return string $method The source of the method
     */
    public function build()
    {
        $method = "\t".$this->access.' function '.$this->name.'('.$this->generateArguments().")\n\t{";
        if ($this->code !== null) {
            $method .= "\n\t\t".$this->code;
        }

        return $method."\n\t}";
    }

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
