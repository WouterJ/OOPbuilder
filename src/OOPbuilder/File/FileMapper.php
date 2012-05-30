<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\File;

use OOPbuilder\File\File;
use OOPbuilder\Exception\BadInstanceOfArgumentException;

/**
 * The FileMapper is used to connect the filesystem with the OOPbuilder\File\File class.
 */
class FileMapper
{
    protected $basepath;

	/**
	 * Sets the basepath of the files.
	 *
	 * @param string $basepath
	 */
    public function setBasePath($basepath)
    {
        $this->basepath = $this->checkBasepath($basepath);
    }

    /**
     * Get all files by extension.
     *
     * @param string $extension
     * @param string $basepath  The basepath, if it is not equal to the global setting
     *
     * @return array
     */
    public function getByExtension($extension, $basepath = null)
    {
        return array_map(array($this, 'populate'), glob($this->checkBasepath($basepath).'*.'.$extension);
    }

    /**
     * Convert data to an object.
     *
     * @param string $name The name of the file
     *
     * @return OOPbuilder\File\File|null Returns the object or null when there is an error
     */
    public function populate($name)
    {
        try {
            return new File($name);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * Create a file on the filesystem.
     *
     * @param OOPbuilder\File\File $file     The file object with the information
     * @param string               $basepath The basepath, if it is not equal to the global setting
     *
     * @return OOPbuilder\File\File The file with the path setted
     *
     * @throws OOPbuilder\Exception\BadInstanceOfArgumentException When $file is not an instance of OOPbuilder\File\File
     * @throws \InvalidArgumentException When the file already exists
     */
    public function create($file, $basepath = null)
    {
        if (!($file instanceof File)) {
            throw new BadInstanceOfArgumentException(
                      sprintf(
                          'The first argument of FileMapper::create() needs to be an instance of OOPbuilder\File\File, an instance of %s is given', 
                          get_class($file)
                      )
                  );
        }

        $basepath = $this->checkBasepath($basepath);
        $path = $basepath.$file->getName().'.'.$file->getExtension();

        if (true === file_exists($path)) {
            throw new \InvalidArgumentException(
                      sprintf(
                          'The FileMapper::create() can only be used on non existing files, the current file (%s) does already exists, use FileMapper::update() instead',
                          $path
                      )
                  );
        }

        $f = fopen($path, 'w');
        if (false === $f) {
            throw new \LogicException('We cannot create the file');
        } else {
            fwrite($f, $file->getContent());
        }
        fclose($f);

        $file->setPath($path);

        return $file;
    }

    /**
     * Update a file on the filesystem.
     *
     * @param OOPbuilder\File\File $file The file object with all data
     * 
     * @return OOPbuilder\File\File
     *
     * @throws OOPbuilder\Exception\BadInstanceOfArgumentException When $file is not an instance of OOPbuilder\File\File
     * @throws \InvalidArgumentException When the file does not exists
     */
    public function update($file)
    {
        if (!($file instanceof File)) {
            throw new BadInstanceOfArgumentException(
                      sprintf(
                          'The first argument of FileMapper::update() needs to be an instance of OOPbuilder\File\File, an instance of %s is given', 
                          get_class($file)
                      )
                  );
        }

        if (false === file_exists($file->getPath())) {
            throw new \InvalidArgumentException(
                      sprintf(
                          'FileMapper::update() can only be used on existing files, the current file (%s) does not exists, use FileMapper::create() instead',
                          $path
                      )
                  );
        }

        $f = fopen($file->getPath(), 'w');
        if (false === $f) {
            throw new \LogicException('We cannot open the file ('.$path.')');
        }
        else {
            fwrite($f, $file->getContent());
        }
        fclose($f);

        return $file;
    }

    /**
     * Delete a file on the file system.
     *
     * @param OOPbuilder\File\File $file The file object with all data
     *
     * @throws OOPbuilder\Exception\BadInstanceOfArgumentException When $file is not an instance of OOPbuilder\File\File
     * @throws \InvalidArgumentException When the file does not exists
     */
    public function delete($file)
    {
        if (!($file instanceof File)) {
            throw new BadInstanceOfArgumentException(
                      sprintf(
                          'The first argument of FileMapper::update() needs to be an instance of OOPbuilder\File\File, an instance of %s is given', 
                          get_class($file)
                      )
                  );
        }

        $path = $file->getPath();
        if (false === file_exists($path)) {
            throw new \InvalidArgumentException(
                           sprintf(
                               'FileMapper::delete() can only delete files who exists, file (%s) does not exists',
                               $path
                           )
                       );
        }

        unlink($path);
    }

    /**
     * Check and parse the basepath.
     *
     * @access private
     *
     * @param string|null $path The basepath
     *
     * @return string The correct basepath
     *
     * @throws \InvalidArgumentException When $path is not a string
     */
    private function checkBasepath($path)
    {
        if (in_array($path, array(null, false))) {
            return $this->basepath;
        }
        if (gettype($path) !== 'string') {
            throw new \InvalidArgumentException(
                           sprintf(
                               'The paths in FileMapper::checkBasepath() needs to be a string, an %s given',
                               gettype($path)
                           )
                       );
        }

        return $path.(!in_array(substr($path, 0, -1), array('/', '\\'))
                        ? DIRECTORY_SEPARATOR
                        : ''
                     );
    }
}
