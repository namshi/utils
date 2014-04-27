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

        array_set($array, 'keys', array('key1', 'key2', 'key3'));
        $this->assertCount(3, array_get($array, '[keys]'));
        $this->assertEquals('key2', array_get($array, '[keys][1]'));
    }
}