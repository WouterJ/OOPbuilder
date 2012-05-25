<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

/**
 * Autoloads the files
 */
class Autoloader
{
    protected $classes;
    protected $basepath = __DIR__;

	/**
	 * Sets the basepath of the files
	 *
	 * @param string $basepath The basepath
	 */
    public function setBasepath($basepath)
    {
        $this->basepath = (!in_array(substr($basepath, -1), array('/', '\\'))
                            ? $basepath.DIRECTORY_SEPARATOR
                            : $basepath
                          );
    }

	/**
	 * Sets a class name
	 *
	 * @param string $class The classname with their namespaces
	 */
    public function set($class)
    {
        $this->classes = $class;
    }

    public function get($class)
    {
        if (!isset($this->classes[$class])) {
            throw new \InvalidArgumentException(
                          sprintf(
                              'The class %s is not found in Autloader',
                              $class
                          )
                      );
        }

        return $this->classes[$class];
    }

	/**
	 * Autoload the files.
	 */
    public function run()
    {
        foreach ($this->classes as $class) {
            require_once $this->basepath.'OOPbuilder'.DIRECTORY_SEPARATOR.$class.'.php';
        }
    }
}
