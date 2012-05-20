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

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $extension;

    public function __construct($name, $extension = null)
    {
        if ($extension == null) {
            if (strpos($name, '.') === false) {
                throw new \InvalidArgumentException('File::__construct() expect a fileextension as second argument, or a dot in the file name. Non of these are found.');
            }

            $info = explode('.', $name);
            $name = array_shift($info);
            $extension = implode('.', $info);
        }

        $this->name = (string) $name;
        $this->extension = (string) $extension;
    }

    public function setPath($path)
    {
        $this->path = (string) realpath($path);
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

    public function getPath()
    {
        return $this->path;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}
