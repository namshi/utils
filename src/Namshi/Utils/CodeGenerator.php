<?php

namespace Namshi\Utils;

/**
 * Random code generator
 */
class CodeGenerator
{
    /**
     * Maximum length of the code to generate for cell verification
     * 
     * @var int
     */
    public static $max_code_length = 5;

    /**
     * Generate random code
     *
     * Code good for two-factor-authentication-challenge
     * Strengthen the challenge by increasing the length
     *
     * @param   int $length
     * @return  string
     */
    public static function generateRandomCode($length = null)
    {
        if (empty ($length) || $length < 0 || !is_numeric($length)) {
            $length = self::$max_code_length;
        }

        return substr(sha1(microtime()), 1, $length);
    }
}
