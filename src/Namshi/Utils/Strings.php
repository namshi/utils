<?php

namespace Namshi\Utils;

/**
 * Class String give you some utilities to work with string.
 */
class Strings
{
    /**
     * Removes double slashes present in the url
     *
     * @param $url
     * @return string
     */
    public static function removeDoubleSlashes($url)
    {
        return preg_replace('#/+#', '/', $url);
    }
}