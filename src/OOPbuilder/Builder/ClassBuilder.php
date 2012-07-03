<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Builder;

use OOPbuilder\Builder\MethodBuilder;
use OOPbuilder\Builder\InterfaceBuilder;
use OOPbuilder\Exception\BadInstanceOfArgumentException;

/**
 * This class builds the class of our project.
 */
class Classbuilder implements BuilderInterface
{
    protected $name;
    protected $extend;
    protected $implement = array();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * Add a method to the class.
	 *
	 * @param OOPbuilder\Builder\MethodBuilder $method A MethodBuilder instance with method information
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
	 * @param OOPbuilder\Builder\PropertyBuilder $property A PropertyBuilder instance with property information
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
     * Extend a class
     *
     * @param string $parent The parent class
     */
    public function extend($parent) 
    {
        $this->extend = $parent;
    }

    /**
     * Implement a interface
     *
     * @param string $interface The interface
     */
    public function implement($interface) 
    {
        $this->implements[] = $interface;
    }

    /**
     * Build the class.
     *
     * @return string The source of the class
     */
    public function build()
    {
		$class = 'class '.$this->name;

        // extend
        if (null !== $this->extend) {
            $class .= ' extends '.$this->extend;
        }

        // implement
        if (0 < count($this->implement)) {
            $class .= ' implements '.implode(', ', $this->implement);
        }

        // build properties
		if ((0 == count($this->properties)) && (0 == count($this->methods))) {
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
