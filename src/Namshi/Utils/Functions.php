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

    if ($key === '[]' || ! $accessor->isReadable($array, $key)) {
        return $default;
    }

    $value = $accessor->getValue($array, $key);

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

/**
 * Returns if the $ip is in the valid ips or subnet masks $validIps, examples:
 * '192.168.100.110, 192.168.100.64/26'                          -> true
 * '192.168.100.110, array(192.168.100.110, 192.168.100.115/26)' -> true
 * '192.168.100.15, 192.168.100.14'                              -> false
 * '55.192.168.100, 192.168.100.64/26'                           -> false
 *
 * @param string $ip
 * @param string|array $validIps
 *
 * @return bool
 */
function validate_ip($ip, $validIps)
{
    $validIps = (array)$validIps;

    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = ip2long($ip);

        foreach ($validIps as $validIp) {
            if (is_scalar($validIp)) {
                $ipParts = explode('/', $validIp);
                $subnet  = ip2long($ipParts[0]);
                $size    = min(isset($ipParts[1]) ? (int)$ipParts[1] : 32, 32);
                $mask    = (pow(2, $size) - 1) << (32 - $size);

                if (($ip & $mask) === ($subnet & $mask)) {
                    return true;
                }
            }
        }
    }

    return false;
}

/**
 * Manipulates $value, which is expected to be a boolean string/integer/true/false and returns
 * the boolean representation of it.
 *
 * If $value does not evaluate to boolean true nor boolean false it returns null
 *
 * @param string|bool|null $value
 *
 * @return bool|null
 */
function boolify($value)
{
    if ($value === 'true' || $value === 1 || $value === true) {
        return true;
    }

    if ($value === 'false' || $value === 0 || $value === false) {
        return false;
    }

    return null;
}
