<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

class Config
{
    protected $setting = array();

    public function set($id, $value)
    {
        $this->$setting[$id] = $value;
    }

    public function get($id)
    {
        if (!isset($this->$setting[$id])) {
            throw new \InvalidArgumentException(
                          sprintf(
                              'The %s setting does not exists in Config::get()',
                              $id
                          )
                      );
        }

        return $this->$setting[$id];
    }
}
