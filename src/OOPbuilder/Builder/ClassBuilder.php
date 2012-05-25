<?php

namespace OOPbuilder\Builder;

use OOPbuilder\Builder\MethodBuilder;
use OOPbuilder\Exception\BadInstanceOfArgumentException;

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

    public function addMethod($method)
    {
        if (!($method instanceof MethodBuilder)) {
            throw new BadInstanceOfArgumentException(
                    sprintf(
                        'The first argument of Classbuilder::addMethod() needs to be an instance of OOPbuilder\Builder\MethodBuilder, an instance of %s is given', 
                        get_class($method)
                    )
                  );
        }
        
        $this->methods[] = $method;
    }

    public function addProperty($property)
    {
        if (!($property instanceof PropertyBuilder)) {
            throw new BadInstanceOfArgumentException(
                    sprintf(
                        'The first argument of Classbuilder::addProperty() needs to be an instance of OOPbuilder\Builder\PropertyBuilder, an instance of %s is given', 
                        get_class($property)
                    )
                  );
        }

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
		if ((array() === $this->properties) && (array() === $this->methods)) {
			$class .= ' {}';
		} else {
			$class .= "\n{";

			foreach ($this->properties as $property) {
				$class .= "\n\t".$property->build();
			}

			if (('{' !== substr($class, -1)) &&  (array() !== $this->methods)) {
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
