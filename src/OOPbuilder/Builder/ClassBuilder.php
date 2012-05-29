<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Builder;

use OOPbuilder\Builder\MethodBuilder;
use OOPbuilder\Exception\BadInstanceOfArgumentException;

/**
 * This class builds the class of our project
 */
class Classbuilder implements BuilderInterface
{
    protected $name;
    protected $properties = array();
    protected $methods = array();

	/**
	 * Constructor.
	 *
	 * @param string $name The name of the class
	 */
    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

	/**
	 * Add a method to the class.
	 *
	 * @param MethodBuilder $method A MethodBuilder instance with method information
     *
     * @throws OOPbuilder\Exception\BadInstanceOfArgumentException When $method is not an instance of MethodBuilder
	 */
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

	/**
	 * Add a property to the class.
	 *
	 * @param PropertyBuilder $property A PropertyBuilder instance with property information
     *
     * @throws OOPbuilder\Exception\BadInstanceOfArgumentException When $property is not an instance of PropertyBuilder
	 */
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
     * Build the class.
     *
     * @return string The source of the class
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
