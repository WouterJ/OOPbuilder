<?php

namespace OOPbuilder\Builder;

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

    public function __construct($name)
    {
        $this->name = $name;
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
        // build method
        return $method;
    }
}
