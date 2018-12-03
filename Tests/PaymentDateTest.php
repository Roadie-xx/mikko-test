<?php

use App\PaymentDate;
use PHPUnit\Framework\TestCase;

class PaymentDateTest extends TestCase
{
    /**
     * Provides test data for finding the date to pay salary
     *
     * @return array
     */
    public function dataProviderSalary() {
        return [
            [2018, 11, '2018-11-30'],
            [2018, 12, '2018-12-31'],
        ];

    }

    /**
     * Provides test data for finding the date to pay bonus
     *
     * @return array
     */
    public function dataProviderBonus() {
        return [
            [2018, 11, '2018-11-15'],
            [2018, 12, '2018-12-19'],
        ];

    }

    /**
     * Provides failing test data for finding dates
     *
     * @return array
     */
    public function dataProviderInvalid() {
        return [
            [null, 1],
            [2018, false],
            [2018, 'feb'],
            ['year', 12],
            [309696, 2495],
        ];
    }

    /**
     * @dataProvider dataProviderSalary
     *
     * @covers PaymentDate::getSalaryDate
     *
     * @param $year
     * @param $month
     * @param $salaryDate
     *
     * @throws Exception
     */
    public function testSalaryDateCanBeCreatedFromValidArguments($year, $month, $salaryDate)
    {
        $date = new PaymentDate($year, $month);

        $this->assertInstanceOf(PaymentDate::class, $date);

        $this->assertEquals($salaryDate, $date->getSalaryDate());
    }

    /**
     * @dataProvider dataProviderBonus
     *
     * @covers PaymentDate::getBonusDate
     *
     * @param $year
     * @param $month
     * @param $bonusDate
     *
     * @throws Exception
     */
    public function testBonusDateCanBeCreatedFromValidArguments($year, $month, $bonusDate)
    {
        $date = new PaymentDate($year, $month);

        $this->assertInstanceOf(PaymentDate::class, $date);

        $this->assertEquals($bonusDate, $date->getBonusDate());
    }

    /**
     * @dataProvider dataProviderInvalid
     *
     * @param $year
     * @param $month
     *
     * @throws Exception
     */
    public function testCanNotBeCreatedFromInvalidArguments($year, $month)
    {
        $this->expectException(InvalidArgumentException::class);

        $date = new PaymentDate($year, $month);

        $this->assertNotInstanceOf(PaymentDate::class, $date);
    }

}
