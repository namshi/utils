<?php

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Returns the value of the index $key in the $array
 * If there is no value, $default is returned
 *
 * @param array       $array
 * @param string      $key
 * @param mixed|null  $default
 *
 * @return mixed
 */
function array_get(array $array, $key, $default = null)
{
    $accessor = PropertyAccess::createPropertyAccessor();
    $value    = $accessor->getValue($array, $key);

    if (empty($value) && !isset($default)) {
        switch (gettype($value)) {
            case 'integer':
                return 0;
            case 'double':
                return 0.0;
            case 'boolean':
                return false;
            case 'string':
                return '';
            case 'array':
                return $value;
            default:
                return null;
        }
    }

    return empty($value) ? $default : $value;
}

/**
 * Sets the value of the index $key in the $array
 *
 * @param mixed $value
 * @param string $key
 * @param array $array
 */
function array_set(array &$array, $key, $value)
{
    $accessor = PropertyAccess::createPropertyAccessor();

    $accessor->setValue($array, sprintf('[%s]', $key), $value);
}

/**
 * Replaces the Arabic numbers with English numbers
 *
 * @param $string
 * @return string
 */
function arabic_numbers_to_english($string)
{
    $arabicNumbers  = array('۰', '۱', '۲', '۳', '٤', '۵', '٦', '۷', '۸', '۹');
    $englishNumbers = range(0, 9);

    return str_replace($arabicNumbers, $englishNumbers, $string);
}