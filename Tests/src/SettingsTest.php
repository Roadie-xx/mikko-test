<?php

use App\PaymentDate;
use App\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    /**
     * Provides test data for successful initiation
     *
     * @return array
     */
    public function dataProviderArguments() {
        return [
            [['testScript.php', ], 2018, date('n'), 'PaymentDates.csv'],
            [['testScript.php TestFile.csv', 'TestFile.csv'], 2018, date('n'), 'TestFile.csv'],
            [['testScript.php TestFile.csv 2019', 'TestFile.csv', '2019'], 2019, 1, 'TestFile.csv'],
        ];
    }

    /**
     * Provides test data for checking on a specified date
     *
     * @return array
     */
    public function dataProviderCreationStamp() {
        return [
            [
                mktime(0,0,0, 3, 4, 2016),
                2016,
                3,
            ],
            [
                mktime(0,0,0, 4, 14, 2017),
                2017,
                4,
            ],
            [
                mktime(0,0,0, 9, 24, 2018),
                2018,
                9,
            ],
        ];
    }

    /**
     * Provides failing test data with wrong Filename Argument
     *
     * @return array
     */
    public function dataProviderWrongFilenameArguments() {
        return [
            [['testScript.php 2019', '2019']],
            [['testScript.php 3490', '3490']],
            [['testScript.php 5.5', '5.5']],
        ];
    }

    /**
     * Provides failing test data with wrong Year Argument
     *
     * @return array
     */
    public function dataProviderWrongYearArguments() {
        return [
            [['testScript.php TestFile.csv ', '']],
            [['testScript.php TestFile.csv early2020', 'TestFile.csv', 'early2020']],
            [['testScript.php TestFile.csv 1960', 'TestFile.csv', '1960']],
            [['testScript.php TestFile.csv 5.5', 'TestFile.csv', '5.5']],
        ];
    }


    /**
     * @dataProvider dataProviderArguments
     *
     * @covers       Settings::__construct
     * @covers       Settings::prepare()
     * @covers       Settings::modifyYear()
     * @covers       Settings::modifyFilename()
     * @covers       Settings::getYear()
     * @covers       Settings::getMonth()
     * @covers       Settings::getFilename()
     *
     * @param $arguments
     * @param $year
     * @param $month
     * @param $fileName
     */
    public function testSettingsCanBeCreatedWithArguments($arguments, $year, $month, $fileName)
    {
        $_SERVER['argv'] = $arguments;

        $settings = new Settings();

        $this->assertInstanceOf(Settings::class, $settings);

        $this->assertEquals($year, $settings->getYear());
        $this->assertEquals($month, $settings->getMonth());
        $this->assertEquals($fileName, $settings->getFilename());
    }

    /**
     * @dataProvider dataProviderCreationStamp
     *
     * @covers       Settings::__construct
     * @covers       Settings::prepare()
     * @covers       Settings::modifyYear()
     * @covers       Settings::getYear()
     * @covers       Settings::getMonth()
     *
     * @param $timestamp
     * @param $year
     * @param $month
     */
    public function testSettingsCanBeCreatedWithCurrentTimestamp($timestamp, $year, $month)
    {
        $_SERVER['argv'] = [];

        $settings = new Settings();
        $settings->prepare($timestamp);

        $this->assertInstanceOf(Settings::class, $settings);

        $this->assertEquals($year, $settings->getYear());
        $this->assertEquals($month, $settings->getMonth());
    }

    /**
     * @dataProvider dataProviderWrongFilenameArguments
     *
     * @covers       Settings::prepare()
     * @covers       Settings::modifyFilename()
     *
     * @param $arguments
     */
    public function testSettingsCanNotBeCreatedWithWrongFilenameArgument($arguments)
    {
        $_SERVER['argv'] = $arguments;

        $this->expectException(InvalidArgumentException::class);
        $settings = new Settings();

        $this->assertNotInstanceOf(Settings::class, $settings);
    }

    /**
     * @dataProvider dataProviderWrongYearArguments
     *
     * @covers       Settings::prepare()
     * @covers       Settings::modifyYear()
     *
     * @param $arguments
     */
    public function testSettingsCanNotBeCreatedWithWrongYearArgument($arguments)
    {
        $_SERVER['argv'] = $arguments;

        $this->expectException(InvalidArgumentException::class);
        $settings = new Settings();

        $this->assertNotInstanceOf(PaymentDate::class, $settings);
    }

}
