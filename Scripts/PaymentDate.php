<?php
namespace App;

/**
 * Class PaymentDate extends the DateTime.
 *
 * This class adds a method to DateTime to find the last working day of the month.
 * It also adds a method to determine the valid payment date for bonuses.
 */
class PaymentDate extends \DateTime
{
    /**
     * @var int Number of the month (1-12)
     */
    private $month;
    /**
     * @var int The year
     */
    private $year;

    /**
     * PaymentDate constructor.
     *
     * @param int $year
     * @param int $month
     *
     * @throws \Exception
     */
    public function __construct($year, $month)
    {
        if (! is_int($year)) {
            throw new \InvalidArgumentException('Wrong input for year: ' . $year);
        }

        if (! is_int($month) || $month < 1 || $month > 12) {
            throw new \InvalidArgumentException('Wrong input for month: ' . $month);
        }

        parent::__construct();

        $this->year  = $year;
        $this->month = $month;

        $this->setDate($year, $month, 1);
    }

    /**
     * For the given month and year, this method returns the date for the last working day.
     *
     * @return string A date formatted 'Y-m-d'
     */
    public function getSalaryDate() {
        $lastDay = $this->format('t');

        $this->setDate($this->year, $this->month, $lastDay);

        if ($this->isWeekend()) {
            $this->modify('last Friday');
        }

        return $this->format('Y-m-d');
    }

    /**
     * If the 15th of the the given month and year is a working day, this method returns this date.
     * Else it returns the date of the first wednesday after the 15th of the month.
     *
     * @return string A date formatted 'Y-m-d'
     */
    public function getBonusDate() {
        $this->setDate($this->year, $this->month, 15);

        if ($this->isWeekend()) {
            $this->modify('next Wednesday');
        }

        return $this->format('Y-m-d');
    }

    /**
     * Checks if date is on saturday or sunday.
     *
     * @return bool
     */
    private function isWeekend() {
        $weekday = $this->format('N');

        if ($weekday === '6' || $weekday === '7') {
            return true;
        }

        return false;
    }
}
