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
    if ($key === '[]') {
        return $default;
    }

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
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        if (!is_array($validIps)) {
            $validIps = [$validIps];
        }

        foreach ($validIps as $validIp) {
            if (is_scalar($validIp)) {
                $validIpParts = explode('/', $validIp);
                $subnet         = array_get($validIpParts, '[0]');
                $bits           = array_get($validIpParts, '[1]', '32');
                $ip             = ip2long($ip);
                $subnet         = ip2long($subnet);
                $mask           = -1 << (32 - $bits);

                if (($ip & $mask) === $subnet) {
                    return true;
                }
            }
        }
    }

    return false;
}
