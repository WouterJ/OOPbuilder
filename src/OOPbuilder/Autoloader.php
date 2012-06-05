<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

/**
 * Autoloads the files.
 */
class Autoloader
{
    protected $classes;
    protected $basepath = __DIR__;

	/**
	 * Sets the basepath of the files.
	 *
	 * @param string $basepath The basepath
	 */
    public function setBasepath($basepath)
    {
        $this->basepath = (in_array(substr($basepath, -1), array('/', '\\'))
                            ? substr($basepath, 0, -1)
                            : $basepath
                          );
    }

	/**
	 * Sets a class name.
	 *
	 * @param array $class An array with the classnames in the keys and their namespaces in the value
	 */
    public function set($class)
    {
        $this->classes = $class;
    }

    /**
     * Gets a namespace.
     *
     * @param string $class The classname
     *
     * @throws \InvalidArgumentException When $class is not found
     *
     * @return string
     */
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
            require_once $this->basepath.DIRECTORY_SEPARATOR.'OOPbuilder'.DIRECTORY_SEPARATOR.$class.'.php';
        }
    }
}
