<?php

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
            throw new InvalidArgumentException('The first parameter of OOPbuilder::__construct() needs to be an instance of OOPbuilder\Config\Config, '.get_class($config).'given');
        }
    }
}
