<?php

namespace OOPbuilder\File;

class File
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $content;

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function setContent($content)
    {
        $this->content = (string) $content;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContent()
    {
        return $this->content;
    }
}
