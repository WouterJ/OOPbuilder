<?php

namespace OOPbuilder;

class Autoloader
{
    protected $classes;
    protected $basepath = __DIR__;

    public function setBasepath($basepath)
    {
        $this->basepath = (!in_array(substr($basepath, -1), array('/', '\\'))
                            ? $basepath.DIRECTORY_SEPARATOR
                            : $basepath
                          );
    }

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

    public function run()
    {
        foreach ($this->classes as $class) {
            require_once $this->basepath.'OOPbuilder'.DIRECTORY_SEPARATOR.$class.'.php';
        }
    }
}
