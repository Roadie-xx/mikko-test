<?php
namespace App;

/**
 * Class Settings.
 *
 * This class is like a placeholder for some settings.
 */
class Settings
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
     * @var string The filename for the csv
     */
    private $filename = 'PaymentDates.csv';

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->prepare();
    }

    /**
     * Sets the default data and checks for arguments
     *
     * @param $now
     */
    public function prepare($now = false)
    {
        if($now === false) {
            $now = time();
        }

        $month = date('n', $now);
        $this->month = intval($month);

        $this->modifyFilename();
        $this->modifyYear($now);
    }

    /**
     * If the command was started with two arguments, the second one is used as year.
     *
     * @param $timestamp
     */
    private function modifyYear($timestamp) {
        $year = date('Y', $timestamp);
        $this->year = intval($year);

        if (isset($_SERVER['argv'][2])) {
            $argument = $_SERVER['argv'][2];

            if (is_numeric($argument) && intval($argument) > 1970) {
                $this->year  = intval($argument);
                $this->month = 1;
            } else {
                throw new \InvalidArgumentException('Wrong argument for year: ' . $argument);
            }
        }
    }

    /**
     * If the command was started with at least one argument, the first one is used as filename.
     */
    private function modifyFilename() {
        if (isset($_SERVER['argv'][1])) {
            $argument = $_SERVER['argv'][1];

            if (is_string($argument) && ! is_numeric($argument) && ! empty($argument)) {
                $this->filename = $argument;
            } else {
                throw new \InvalidArgumentException('Wrong argument for filename: ' . $argument);
            }
        }
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

}
