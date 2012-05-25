<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\File;

/**
 * Represends one single file
 */
class File
{
    protected $name;
    protected $content;
    protected $path;
    protected $extension;

	/**
	 * Constructor.
	 *
	 * @param string	  $name		 The name of the file, 
	 *								 if a dot is in here everything after the last dot is the file extension
	 * @param string|null $extension The extension of the file, if not already set in the first parameter, otherwise this is optional
	 *
	 * @throws \InvalidArgumentException When there isn't set a file extension
	 */
    public function __construct($name, $extension = null)
    {
        if (null === $extension) {
            if (false === strpos($name, '.')) {
                throw new \InvalidArgumentException('File::__construct() expect a file-extension as second argument, or a dot in the file name (first argument), none of these are found.');
            }

            $info = explode('.', $name);
            $name = array_shift($info);
            $extension = implode('.', $info);
        }

        $this->name = (string) $name;
        $this->extension = (string) $extension;
    }

	/**
	 * Sets the path of the file.
	 *
	 * @param string $path
	 */
    public function setPath($path)
    {
        $this->path = (string) realpath($path);
    }

	/**
	 * Sets the content of the file.
	 *
	 * @param string $content
	 */
    public function setContent($content)
    {
        $this->content = (string) $content;
    }

	/**
	 * Get the name of the file.
	 *
	 * @return string
	 */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * Get the content of the file.
	 *
	 * @return string
	 */
    public function getContent()
    {
        return $this->content;
    }

	/**
	 * Get the path of the file.
	 *
	 * @return string
	 */
    public function getPath()
    {
        return $this->path;
    }

	/**
	 * Get the extension of the file.
	 *
	 * @return string
	 */
    public function getExtension()
    {
        return $this->extension;
    }
}
