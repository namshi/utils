<?php

namespace Namshi\Utils\Test;

use \PHPUnit_Framework_TestCase;
use Namshi\Utils\Strings;

class StringTest extends PHPUnit_Framework_TestCase
{
    public function testRemoveDoubleSlashes()
    {
        $this->assertEquals('test1/test2', Strings::removeDoubleSlashes('test1//test2'));
    }

    public function testRemoveDoubleSlashesAtTheBeginningOfString()
    {
        $this->assertEquals('/test1/test2', Strings::removeDoubleSlashes('//test1//test2'));
    }

    public function testRemoveDoubleSlashesAtTheEndOfString()
    {
        $this->assertEquals('test1/test2/', Strings::removeDoubleSlashes('test1//test2//'));
    }
}