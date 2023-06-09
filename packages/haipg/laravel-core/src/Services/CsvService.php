<?php

namespace HaiPG\LaravelCore\Services;



class CsvService
{
    const UTF_8 = 'UTF-8';
    const SJIS = 'SJIS';

    /**
     * Get data in file csv downloaded from S3
     *
     * @param string $csvPath
     * @return false|string[]
     */
    public static function getDataFromJpFile(string $csvPath): array|bool
    {
        $csvFile = fopen($csvPath, 'r');
        $isUTF8 = mb_check_encoding(file_get_contents($csvPath), self::UTF_8);
        $content = [];

        if ($csvFile !== false) {
            while (
                $row = $isUTF8
                    ? fgetcsv($csvFile)
                    : mb_convert_encoding(fgetcsv($csvFile), self::UTF_8, self::SJIS)
            ) {
                $dataRow = str_replace('"', "'", $row);
                $data = implode('", "', array_map(function ($entry) {
                    return $entry;
                }, str_replace(PHP_EOL, '', $dataRow)));
                $content[] = '"' . $data . '"';
            }
        }

        fclose($csvFile);

        return $content;
    }
}
