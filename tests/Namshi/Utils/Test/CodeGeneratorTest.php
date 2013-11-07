<?php

namespace Namshi\Utils\Test;

use \PHPUnit_Framework_TestCase;
use Namshi\Utils\CodeGenerator;

class CodeGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testGenerateCodeWithDefaultLength()
    {
        $this->assertEquals(CodeGenerator::$max_code_length, strlen(CodeGenerator::generateRandomCode()));
    }

    public function testGenerateCodeWithWithSpecificLength()
    {
        $this->assertEquals(10, strlen(CodeGenerator::generateRandomCode(10)));
    }

    public function testGenerateCodeWithWithInvalidLength()
    {
        $this->assertEquals(CodeGenerator::$max_code_length, strlen(CodeGenerator::generateRandomCode(-10)));
    }

    public function testGenerateCodeWithWithNotNumericLength()
    {
        $this->assertEquals(CodeGenerator::$max_code_length, strlen(CodeGenerator::generateRandomCode('not numeric')));
    }

    public function testGenerateCodeWithWithZeroLength()
    {
        $this->assertEquals(CodeGenerator::$max_code_length, strlen(CodeGenerator::generateRandomCode(0)));
    }
}