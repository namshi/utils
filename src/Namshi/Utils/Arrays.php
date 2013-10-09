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

    /**
     * Sorts the $array based on the values of $order. Keys in $array that are not included in $order will be appended
     * after every other element has been sorted.
     *
     * @param array $array
     * @param array $order
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function sort(array $array, array $order)
    {
        $diff = array_diff($order, array_keys($array));

        if (count($diff)) {
            throw new \InvalidArgumentException("You cannot sort an array that doesnt contain all the values to order by");
        }

        return array_merge(array_flip($order), $array);
    }
}