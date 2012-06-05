<?php

namespace OOPbuilder\Tests;

use OOPbuilder\Helper;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAccess()
    {
        $this->assertTrue(Helper::is_access('public'));
        $this->assertTrue(Helper::is_access('private'));
        $this->assertTrue(Helper::is_access('protected'));

        $this->assertFalse(Helper::is_access('foobar'));
    }

    public function testClass2Path()
    {
        $this->assertEquals('WouterJ\Blog\Article.php', Helper::class2path('WouterJ\Blog\Article'));
        $this->assertEquals('WouterJ\Blog\Article.php', Helper::class2path('WouterJ_Blog_Article'));
    }
}
