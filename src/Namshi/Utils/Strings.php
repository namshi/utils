<?php

namespace Namshi\Utils;

/**
 * Class Strings give you some utilities to work with strings.
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