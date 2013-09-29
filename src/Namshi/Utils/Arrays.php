<?php

namespace Namshi\Utils;

/**
 * Class Arrays give you some utilities to work with arrays.
 */
class Arrays
{
    /**
     * Compares the $master array with the $slave, returning the difference between them.
     *
     * @param array $master
     * @param array $slave
     * @return array
     */
    public static function compare(array $master, array $slave)
    {
        $diff = array();

        foreach ($master as $key => $value) {
            if (isset($slave[$key])) {
                if (is_array($value) ) {
                    $subDiff = static::compare($value, $slave[$key]);

                    if (count($subDiff)) {
                        $diff[$key] = $subDiff;
                    }
                } elseif ($master[$key] != $slave[$key]) {
                    $diff[$key] = $value;
                }
            } else {
                $diff[$key] = $value;
            }
        }

        return $diff;
    }
}