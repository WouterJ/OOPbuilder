<?php

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
            throw new InvalidArgumentException('The '.$id.' setting does not exists in Config::get()');
        }

        return $this->$setting[$id];
    }
}
