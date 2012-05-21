<?php

namespace OOPbuilder\File;

use OOPbuilder\File\File;

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
        return new File($name);
    }

    public function create(File $file, $basepath = null)
    {
        $basepath = $this->checkBasepath($basepath);
        $path = $basepath.$file->getName().'.'.$file->getExtension();
        if (file_exists($path)) {
            throw new \InvalidArgumentException('The FileMapper::create() can only be used on non existing files, the current file ('.$path.') does already exists, use FileMapper::update() instead');
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

    public function update(File $file)
    {
        if (!file_exists($file->getPath())) {
            throw new \InvalidArgumentException('FileMapper::update() can only be used on existing files, the current file ('.$path.') does not exists, use FileMapper::create() instead');
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

    public function delete(File $file)
    {
        $path = $file->getPath();
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('FileMapper::delete() can only delete files who exists, file ('.$path.') does not exists');
        }

        unlink($path);
    }

    private function checkBasepath($path)
    {
        if (in_array($path, array(null, false))) {
            return $this->basepath;
        }
        if (gettype($path) !== 'string') {
            throw new \InvalidArgumentException('The paths in FileMapper needs to be a string');
        }

        return $path.(!in_array(substr($path, 0, -1), array('/', '\\'))
                        ? DIRECTORY_SEPARATOR
                        : ''
                     );
    }
}
