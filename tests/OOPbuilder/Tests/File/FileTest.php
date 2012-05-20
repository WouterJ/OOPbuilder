<?php

namespace OOPbuilder\Tests\File;

use OOPbuilder\File\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testExtensions()
    {
        $f = new File('foo.txt');
        $this->assertEquals('foo', $f->getName());
        $this->assertEquals('txt', $f->getExtension());

        $f = new File('foo', 'txt');
        $this->assertEquals('foo', $f->getName());
        $this->assertEquals('txt', $f->getExtension());

        $f = new File('foo.class.php');
        $this->assertEquals('foo', $f->getName());
        $this->assertEquals('class.php', $f->getExtension());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNoExtension()
    {
        $f = new File('foo');
    }

    public function testContent()
    {
        $f = new File('foo.txt');
        $f->setContent('Lorem ipsum dolor sit amet.');

        $this->assertEquals('Lorem ipsum dolor sit amet.', $f->getContent());
    }
}
