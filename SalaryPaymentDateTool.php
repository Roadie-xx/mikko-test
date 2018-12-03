<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

$filename = 'PaymentDates.csv';

if (isset($_SERVER['argv'][1]) && ! empty($_SERVER['argv'][1])) {
    $filename = $_SERVER['argv'][1];
}

// Mainly for testing purposes... Current year is almost done
$globalYear   = '2019';
$currentMonth = date('n');

if (isset($_SERVER['argv'][2]) && ! empty($_SERVER['argv'][2])) {
    $filename     = $_SERVER['argv'][2];
    $currentMonth = 1;
}

$data = [
    ['Month', 'Salary payment date', 'Bonus payment date']
];

for ($i = $currentMonth; $i <= 12; $i++) {
    $salaryPaymentDate = findSalaryPaymentDate($i, $globalYear);
    $bonusPaymentDate  = findBonusPaymentDate($i, $globalYear);

    // Add row with payment dates
    $data[] = [$months[$i], $salaryPaymentDate, $bonusPaymentDate];
}


if (file_exists($filename)) {
    unlink($filename);
}

$fp = fopen($filename, 'w');

foreach ($data as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

echo '<pre>';
readfile($filename);


function findSalaryPaymentDate($monthNumber, $year) {
    // Build date as a string, use day 1
    $dateString = "$year-$monthNumber-01";

    // Find last day of the month
    $lastDayThisMonth = date("Y-m-t", strtotime($dateString));

    // Get weekday
    $weekday = date('N', strtotime($lastDayThisMonth));

    if ($weekday === '6' || $weekday === '7') {
        // Returns previous friday
        return date('Y-m-d', strtotime($lastDayThisMonth . ' last Friday'));
    }

    return $lastDayThisMonth;
}

function findBonusPaymentDate($monthNumber, $year) {
    // Build date as a string, use day 15
    $dateString = date("Y-m-d", strtotime("$year-$monthNumber-15"));

    // Get weekday
    $weekday = date('N', strtotime($dateString));

    if ($weekday === '6' || $weekday === '7') {
        // Returns next wednesday
        return date('Y-m-d', strtotime($dateString . ' next Wednesday'));
    }

    return $dateString;
}
