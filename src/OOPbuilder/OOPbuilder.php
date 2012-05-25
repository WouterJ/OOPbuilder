<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

use OOPbuilder\Config;

class OOPbuilder
{
    protected $config;

    public function __construct($config)
    {
        if ($config instanceof Config) {
            $this->config = $config;
        } else {
            throw new \InvalidArgumentException(
                          sprintf(
                              'The first parameter of OOPbuilder::__construct() needs to be an instance of OOPbuilder\Config\Config, %s given',
                              get_class($config)
                          )
                      );
        }
    }
}
