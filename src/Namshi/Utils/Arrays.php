<?php

namespace Namshi\Utils;

/**
 * Class Arrays give you some utilities to work with arrays.
 */
class Arrays
{
    /**
     * Compares the $master array with the $slave, returning the difference between them.
     * $excludeKeys is an array that can contains keys that will be not used during the comparison.
     * If $fullArrayOutput is true, the output will contain not just the keys that differs but also
     * the whole array those keys belong to.
     *
     * @param array $master
     * @param array $slave
     * @param array $excludeKeys
     * @return array
     */
    public static function compare(array $master, array $slave, $excludeKeys = array(), $fullArrayOutput = false)
    {
        $diff = array();

        foreach ($master as $key => $value) {

            if(!in_array($key, $excludeKeys, true)){
                if (isset($slave[$key])) {
                    if (is_array($value) && is_array($slave[$key])) {
                        $subDiff = static::compare($value, $slave[$key], $excludeKeys, $fullArrayOutput);

                        if (count($subDiff)) {
                            $diff[$key] = $subDiff;
                        }
                    } elseif ($master[$key] != $slave[$key]) {
                        $masterOutput = $fullArrayOutput ? $master : $master[$key];
                        $slaveOutput  = $fullArrayOutput ? $slave  : $slave[$key];

                        $diff[$key] = array(
                            $masterOutput,
                            $slaveOutput,
                        );
                    }
                } else {
                    if(isset($master[$key])) {
                        $diff[$key] = array($value, null);
                    }
                }
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