<?php

namespace Namshi\Utils\Test;

use \PHPUnit_Framework_TestCase;
use Namshi\Utils\Arrays;

class ArraysTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testOrderingAnEmptyArray()
    {
        $this->assertEquals(array(
            'a' => null,
            'b' => null,
        ), Arrays::sort(array(), array('a', 'b')));
    }

    public function testOrderingASimpleArray()
    {
        $this->assertEquals(array(
            'a' => 2,
            'b' => 0,
        ), Arrays::sort(array('b' => 0, 'a' => 2), array('a', 'b')));
    }

    public function testOrderingAnArrayWithExceedingValues()
    {
        $this->assertEquals(array(
            'a' => 2,
            'b' => 0,
            'c' => 'hello',
        ), Arrays::sort(array('c' => 'hello', 'b' => 0, 'a' => 2), array('a', 'b')));
    }

    public function testComparingTwoFlatArrays()
    {
        $this->assertCount(0, Arrays::compare(array(1,2,3), array(1,2,3)));
        $this->assertCount(0, Arrays::compare(array(1 => 2, 2 => 3, 3 => 4), array(3 => 4, 1 => 2, 2 => 3)));
    }

    public function testComparingNonIdenticalArrays()
    {
        $master = array('hello' => 'world', array(
            1 => 2,
        ));

        $slave = array('world' => 'hello', array(
            2 => 1
        ));

        $this->assertCount(2, Arrays::compare($master, $slave));
        $this->assertArrayHasKey('hello', Arrays::compare($master, $slave));
        $this->assertArrayHasKey(0, Arrays::compare($master, $slave));
        $this->assertEquals(array(
            'world', null
        ), Arrays::compare($master, $slave)['hello']);
        $this->assertEquals(array(
            1 => array(2, null)
        ), Arrays::compare($master, $slave)[0]);

        $master = array(
            'key' => 'val1'
        );

        $slave = array(
            'key' => 'val2'
        );

        $this->assertEquals(array(
            'key' => array('val1', 'val2')
        ), Arrays::compare($master, $slave));

        $master = array(
            'key' => array(1)
        );

        $slave = array(
            'key' => 'val2'
        );

        $this->assertEquals(array(
            'key' => array(array(1), 'val2')
        ), Arrays::compare($master, $slave));
    }

    public function testComparingTwoMultiDimensionalArrays()
    {
        $master = array(
            'hello' => array(
                1 => 'world',
                2 => array(
                    array(
                        array(
                            3 => 'php'
                        )
                    )
                ),
            ),
            'ciao' => array(
                1 => 'mondo',
                2 => array(
                    array(
                        array(
                            3 => 'php'
                        )
                    )
                ),
            )
        );
        $slave  = array(
            'ciao' => array(
                1 => 'mondo',
                2 => array(
                    array(
                        array(
                            3 => 'php'
                        )
                    )
                ),
            ),
            'hello' => array(
                1 => 'world',
                2 => array(
                    array(
                        array(
                            3 => 'php'
                        )
                    )
                ),
            )
        );

        $this->assertCount(0, Arrays::compare($master, $slave));
    }
}