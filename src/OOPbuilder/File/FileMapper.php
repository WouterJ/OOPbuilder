<?php

namespace OOPbuilder\File;

use OOPbuilder\File\File;
use OOPbuilder\Exception\BadInstanceOfArgumentException;

class FileMapper
{
    protected $basepath;

    public function setBasePath($basepath)
    {
        $this->basepath = $this->checkBasepath($basepath);
    }

    public function getByExtension($extension, $basepath = null)
    {
        return array_map(array($this, 'populate'), glob($this->checkBasepath($basepath).'*.'.$extension);
    }

    public function populate($name)
    {
        try {
            return new File($name);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

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

        if (file_exists($path)) {
            throw new \InvalidArgumentException(
                      sprintf(
                          'The FileMapper::create() can only be used on non existing files, the current file (%s) does already exists, use FileMapper::update() instead',
                          $path
                      )
                  );
        }

        $f = fopen($path, 'w');
        if ($f == false) {
            throw new \LogicException('We cannot create the file');
        }
        else {
            fwrite($f, $file->getContent());
        }
        fclose($f);

        $file->setPath($path);

        return $file;
    }

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

        if (!file_exists($file->getPath())) {
            throw new \InvalidArgumentException(
                      sprintf(
                          'FileMapper::update() can only be used on existing files, the current file (%s) does not exists, use FileMapper::create() instead',
                          $path
                      )
                  );
        }

        $f = fopen($file->getPath(), 'w');
        if ($f == false) {
            throw new \LogicException('We cannot open the file ('.$path.')');
        }
        else {
            fwrite($f, $file->getContent());
        }
        fclose($f);

        return $file;
    }

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
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(
                           sprintf(
                               'FileMapper::delete() can only delete files who exists, file (%s) does not exists',
                               $path
                           )
                       );
        }

        unlink($path);
    }

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
