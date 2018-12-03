<?php

use App\FileHelper;
use PHPUnit\Framework\TestCase;

class FileHelperTest extends TestCase
{

    /**
     * Provides test data for writing an array to a CSV file
     *
     * @return array
     */
    public function dataProvider() {
        return [
            [
                tempnam(sys_get_temp_dir(), 'PaymentDateCSVWriter'),
                [
                    ['Header1', 'Header2', 'Header3'],
                    ['Data101', 'Data102', 'Data103'],
                    ['Data201', 'Data202', 'Data203'],
                    ['Data301', 'Data302', 'Data303'],
                ],
            ],
            [
                tempnam(sys_get_temp_dir(), 'TempWriter'),
                [
                    ['HeaderA', 'HeaderB', 'HeaderC'],
                    ['DataA1', 'DataB1', 'DataC1'],
                    ['DataA2', 'DataB2', 'DataC2'],
                    ['DataA3', 'DataB3', 'DataC3'],
                ],
            ],
        ];
    }

    /**
     * Provides failing test data
     *
     * @return array
     */
    public function dataProviderFails() {
        return [
            ['', [['header']]],
            [null, [['header']]],
            [false, [['header']]],
            [false, []],
            [tempnam(sys_get_temp_dir(), 'test'), []],

        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @covers       FileHelper::writeCSVFile()
     *
     * @param $filename
     * @param $data
     */
    public function testCanWriteCorrectDataToFile($filename, $data)
    {
        $this->assertFileExists($filename);

        FileHelper::writeCSVFile($filename, $data);

        $this->assertFileExists($filename);

        $file = file_get_contents($filename);

        $this->assertEquals(count($data), count(explode("\n", trim($file))));

        foreach ($data as $row) {
            foreach ($row as $cell) {
                $this->assertContains($cell, $file);
            }
        }

        $this->assertTrue(unlink($filename));
    }

    /**
     * @dataProvider dataProvider
     *
     * @covers       FileHelper::writeCSVFile()
     *
     * @param $filename
     * @param $data
     */
    public function testCanOverwriteFile($filename, $data)
    {
        $this->assertFileExists($filename);

        FileHelper::writeCSVFile($filename, [['Unwanted header']]);

       $this->assertFileExists($filename);

        FileHelper::writeCSVFile($filename, $data);

        $this->assertFileExists($filename);

        $file = file_get_contents($filename);

        $this->assertEquals(count($data), count(explode("\n", trim($file))));

        foreach ($data as $row) {
            foreach ($row as $cell) {
                $this->assertContains($cell, $file);
            }
        }

        $this->assertTrue(unlink($filename));
    }

    /**
     * @dataProvider dataProviderFails
     *
     * @covers       FileHelper::writeCSVFile()
     *
     * @param $filename
     * @param $data
     */
    public function testCanNotWriteFileWithoutData($filename, $data)
    {
        $this->expectException(InvalidArgumentException::class);

        FileHelper::writeCSVFile($filename, $data);

        $this->assertTrue(unlink($filename));
    }

}
