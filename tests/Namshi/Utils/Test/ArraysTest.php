<?php

namespace Namshi\Utils\Test;

use \PHPUnit_Framework_TestCase;
use Namshi\Utils\Arrays;

class ArraysTest extends PHPUnit_Framework_TestCase
{
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
        $this->assertEquals('world', Arrays::compare($master, $slave)['hello']);
        $this->assertEquals(array(1=>2), Arrays::compare($master, $slave)[0]);
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