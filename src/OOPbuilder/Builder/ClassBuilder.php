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
        $this->name = ucfirst($name);
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
		$class = 'class '.$this->name;
		if ($this->properties == array() && $this->methods == array()) {
			$class .= ' {}';
		}
		else {
			$class .= "\n{";

			foreach ($this->properties as $property) {
				$class .= "\n\t".$property->build();
			}

			if (substr($class, -1) !== '{' && $this->methods !== array()) {
				$class .= "\n";
			}

			foreach ($this->methods as $method) {
				$class .= "\n".$method->build()."\n";
			}

			$class .= "}";
		}

        return $class;
    }
}
