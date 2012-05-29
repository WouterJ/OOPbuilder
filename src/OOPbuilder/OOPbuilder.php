<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

use OOPbuilder\Config;

/**
 * The frontcontroller of OOPbuilder, this handles everything
 */
class OOPbuilder
{
    protected $config;

    /**
     * Constructor.
     *
     * @param OOPbuilder\Config\Config $config The config repository
     *
     * @throws \InvalidArgumentException When $config is not an instance of OOPbuilder\Config
     */
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
