<?php

namespace OOPbuilder\File;

class FileMapper
{
    protected $basepath;

    public function addBasePath($basepath)
    {
        $this->basepath = $this->checkPath($basepath);
    }

    public function create(File $file, $basepath = null)
    {
        $basepath = $this->checkPath($basepath);
        $path = $basepath.$file->getName().'.'.$file->getType();
        if (file_exists($path)) {
            throw new InvalidArgumentException('The FileMapper::create() can only be used on non existing files, the current file ('.$path.') does already exists');
        }

        $f = fopen($path);
        if ($f == false) {
            throw new LogicException('We cannot create the file');
        }
        else {
        }
    }

    public function update(File $file, $basepath = null)
    {
    }

    private function checkBasepath($path)
    {
        if (in_array($path, array(null, false))) {
            return $this->basepath;
        }
        if (gettype($path) !== 'string') {
            throw new InvalidArgumentException('The paths in FileMapper needs to be a string');
        }

        return $path.(!in_array(substr($path, 0, -1), array('/', '\\')
                        ? DIRECTORY_SEPARATOR
                        : ''
                     );
    }
}
