<?php

namespace OOPbuilder\Builder;

class Classbuilder implements BuilderInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $properties = array();

    /**
     * @var array
     */
    protected $methods = array();

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addMethod(MethodBuilder $method)
    {
        $this->methods[] = $method;
    }

    public function addProperty(PropertyBuilder $property)
    {
        $this->properties[] = $property;
    }

    /**
     * Builds a class
     *
     * @return string $class The source of the class
     */
    public function build()
    {
        // build class
        return $class;
    }
}
