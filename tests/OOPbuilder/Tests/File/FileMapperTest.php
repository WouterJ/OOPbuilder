<?php

namespace OOPbuilder\Tests\File;

use OOPbuilder\File\FileMapper;
use OOPbuilder\File\File;

class FileMapperTest extends \PHPUnit_Framework_TestCase
{
    protected $mapper;

    public function setUp()
    {
        foreach (glob(__DIR__.'/testFiles/*') as $file) {
            unlink($file);
        }
        $this->mapper = new FileMapper();
        $this->mapper->setBasePath(__DIR__.'/testFiles/');
    }

    public function testCreatingFiles()
    {
        $f = new File('foo.txt');
        $f->setContent('Lorem ipsum dolor mir subset.');

        $f = $this->mapper->create($f);
        $this->assertTrue(file_exists(__DIR__.'/testFiles/foo.txt'));

        $this->assertInstanceOf('OOPbuilder\File\File', $f);
        $this->assertEquals('Lorem ipsum dolor mir subset.', $f->getContent());
    }

    public function testDeletingFiles()
    {
        $f = new File('foo.txt');
        $f->setContent('Lorem ipsum dolor mir subset.');

        $this->mapper->create($f);
        $this->assertTrue(file_exists(__DIR__.'/testFiles/foo.txt'));

        $this->mapper->delete($f);
        $this->assertFalse(file_exists(__DIR__.'/testFiles/foo.txt'));
    }

    public function testUpdatingFiles()
    {
        $f = new File('foo.txt');
        $f->setContent('Lorem ipsum dolor mir subset.');

        $this->mapper->create($f);
        $this->assertTrue(file_exists(__DIR__.'/testFiles/foo.txt'));

        $f->setContent('New content.');

        $f = $this->mapper->update($f);
        $this->assertInstanceOf('OOPbuilder\File\File', $f);
        $this->assertEquals('New content.', $f->getContent());
    }
}
