<?php
namespace App;

/**
 * Class FileHelper.
 */
class FileHelper
{
    /**
     * If the file exists, delete it and writes the file with the data
     *
     * @param string $filename
     * @param array  $data
     */
    public static function writeCSVFile($filename, $data)
    {
        if(empty($filename)) {
            throw new \InvalidArgumentException('Wrong filename: ' . $filename);
        }

        if(empty($data)) {
            throw new \InvalidArgumentException('Wrong data: ' . print_r($filename, true));
        }

        if (file_exists($filename)) {
            unlink($filename);
        }

        $fp = fopen($filename, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }


}
