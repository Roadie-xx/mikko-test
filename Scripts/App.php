<?php
namespace App;

/**
 * Class App.
 *
 * This is the main class .
 */
class App
{
    /**
     * @var array
     */
    private $csvData = [];
    /**
     * @var array Contains the long month names
     */
    private $months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    /**
     * @var Settings
     */
    private $settings;


    /**
     * Builder constructor.
     *
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Clears the data array and refills the first row with the header columns
     */
    private function buildHeader()
    {
        $this->csvData   = [];
        $this->csvData[] = ['Month', 'Salary payment date', 'Bonus payment date'];
    }

    /**
     * For the remaining months of the year adds the data to the array
     */
    private function addData()
    {
        for ($month = $this->settings->getMonth(); $month <= 12; $month++) {
            $year = $this->settings->getYear();
            $date = new PaymentDate($year, $month);

            $salaryPaymentDate = $date->getSalaryDate();
            $bonusPaymentDate  = $date->getBonusDate();

            // Add row with month name and both payment dates
            $this->csvData[] = [$this->months[$month], $salaryPaymentDate, $bonusPaymentDate];
        }
    }

    /**
     * Generates the csv file
     *
     * @return string
     */
    public function generate() {
        $this->buildHeader();
        $this->addData();

        FileHelper::writeCSVFile($this->settings->getFilename(), $this->csvData);

        return file_get_contents($this->settings->getFilename());
    }

}
