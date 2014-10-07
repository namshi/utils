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

    protected static $dictionary = 'qwertyuiopasdfghjklzxcvbnm1234567890';

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
        $length = min((int)$length, 40);

        if ($length <= 0) {
            $length = self::$max_code_length;
        }

        for ($code = '', $maxOffset = strlen(self::$dictionary) - 1; $length--;) {
            $code .= self::$dictionary[mt_rand(0, $maxOffset)];
        }

        return $code;
    }

}
