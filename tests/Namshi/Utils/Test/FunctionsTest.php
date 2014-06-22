<?php


class FunctionsTest extends PHPUnit_Framework_TestCase
{
    public function testTranslateArabicNumbersToEnglish()
    {
        $englishNumbers = arabic_numbers_to_english('۱۲۵۹۸۱۲۵۹۸۱۱۲۵۹۸۱۱۵۹۸۱٦٤۰');

        $this->assertEquals('1259812598112598115981640', $englishNumbers);
    }

    public function testTranslateArabicAndEnglishNumbersToEnglish()
    {
        $englishNumbers = arabic_numbers_to_english('12۵۹۸۱۲۵98۱۱۲۵۹۸۱۱59۸۱٦٤۰');

        $this->assertEquals('1259812598112598115981640', $englishNumbers);
    }

    public function testTranslateOneArabicNumberToEnglish()
    {
        $englishNumbers = arabic_numbers_to_english('٤');

        $this->assertEquals('4', $englishNumbers);
    }

    public function testTranslateEmptyStringToEnglish()
    {
        $englishNumbers = arabic_numbers_to_english('');

        $this->assertEquals('', $englishNumbers);
    }

    public function testArrayGetAndSetValues()
    {
        $array = array(
            'key1' => 'val1',
            'key2' => 'val2',
            'key3' => 'val3'
        );

        $this->assertEquals(array_get($array, '[key2]'), 'val2');
        $this->assertEquals(array_get($array, '[notExist]', 5), 5);
        $this->assertNull(array_get($array, '[key]'));

        array_set($array, 'key', 5);
        $this->assertEquals(array_get($array, '[key]'), 5);
        $this->assertNull(array_get($array, '[]'));
        $this->assertEquals('default', array_get($array, '[]', 'default'));

        array_set($array, 'keys', array('key1', 'key2', 'key3'));
        $this->assertCount(3, array_get($array, '[keys]'));
        $this->assertEquals('key2', array_get($array, '[keys][1]'));
    }

    public function testValidateIpWithValidIp()
    {
        $valid = validate_ip('192.168.100.110', '192.168.100.64/26');

        $this->assertTrue($valid);
    }

    public function testValidateIpWithValidIpAndArrayOfRanges()
    {
        $valid = validate_ip('192.168.100.110', array(
            '192.168.100.64/26',
            '10.168.100.64/26',
            '15.168.100.64/26'
        ));

        $this->assertTrue($valid);
    }

    public function testValidateIpWithValidIpAndArrayOfIps()
    {
        $valid = validate_ip('192.168.100.110', array(
            '192.168.100.110',
            '192.168.100.115',
            '192.168.100.0'
        ));

        $this->assertTrue($valid);
    }

    public function testValidateIpWithValidIpAndArrayOfIpsNotInTheArray()
    {
        $valid = validate_ip('192.168.100.110', array(
            '192.168.100.115',
            '192.168.100.0'
        ));

        $this->assertFalse($valid);
    }

    public function testValidateIpWithValidIpAndEmptyArrayOfIps()
    {
        $valid = validate_ip('192.168.100.110', array());

        $this->assertFalse($valid);
    }

    public function testValidateIpWithValidIpAndTheSameIp()
    {
        $valid = validate_ip('192.168.100.110', '192.168.100.110');

        $this->assertTrue($valid);
    }

    public function testValidateIpWithValidIpAndDifferentIp()
    {
        $valid = validate_ip('192.168.100.110', '192.168.100.111');

        $this->assertFalse($valid);
    }

    public function testValidateIpWithIpNotInTheRange()
    {
        $valid = validate_ip('55.192.168.100', '192.168.100.64/26');

        $this->assertFalse($valid);
    }

    public function testValidateIpWithIpAndObject()
    {
        $valid = validate_ip('55.192.168.100', new stdClass());

        $this->assertFalse($valid);
    }

    public function testValidateIpWithIpAndBoolean()
    {
        $valid = validate_ip('55.192.168.100', true);

        $this->assertFalse($valid);
    }

    public function testValidateIpWithIpAndInteger()
    {
        $valid = validate_ip('55.192.168.100', 55);

        $this->assertFalse($valid);
    }

    public function testValidateIpWithIpAndFloat()
    {
        $valid = validate_ip('55.192.168.100', 55.5);

        $this->assertFalse($valid);
    }

    public function testValidateIpWithValidIpCompleteRangeAnd32Mask()
    {
        $valid = validate_ip('192.168.100.15', '0.0.0.0/32');

        $this->assertFalse($valid);
    }

    public function testValidateIpWithInValidIp()
    {
        $valid = validate_ip('Invalid Ip', '192.168.100.64/26');

        $this->assertFalse($valid);
    }

    public function testValidateIpWithInValidRange()
    {
        $valid = validate_ip('192.168.100.110', 'Invalid Range');

        $this->assertFalse($valid);
    }

    public function testValidateIpWithInValidRangeAndInvalidIp()
    {
        $valid = validate_ip('Invalid Ip', 'Invalid Range');

        $this->assertFalse($valid);
    }
}