<?php

namespace HaiPG\LaravelCore\Common;

class DatetimeHelper
{
    const DATE_STR_FORMAT_JA  = '%s年%s月%s日';
    const MONTH_STR_FORMAT_JA = '%s年%s月';
    const DELIMITER_HYPHEN    = '-';
    const DATE_FORMAT         = 'Ymd';

    /**
     * Convert to date (Ja)
     *
     * @param string $date
     * @return string
     */
    public static function convertDateFormatJa(string $date)
    {
        if (empty($date)) {
            return $date;
        }

        $divisions = explode(self::DELIMITER_HYPHEN, $date);

        if (count($divisions) != 3) {
            return $date;
        }

        return sprintf(
            self::DATE_STR_FORMAT_JA,
            $divisions [0],
            $divisions [1],
            $divisions [2]
        );
    }

    /**
     * Convert to month (Ja)
     *
     * @param string $month
     * @return string
     */
    public static function convertMonthFormatJa(string $month)
    {
        if (empty ($month)) {
            return $month;
        }

        // 月をハイフンで分割
        $divisions = explode(self::DELIMITER_HYPHEN, $month);

        if (count($divisions) != 2) {
            return $month;
        }

        return sprintf(
            self::MONTH_STR_FORMAT_JA,
            $divisions [0],
            $divisions [1]
        );
    }

    /**
     * Calculate age from birthday
     *
     * @param string $birthday
     * @return false|float
     */
    public static function calculateAge(string $birthday)
    {
        $now      = date(self::DATE_FORMAT);
        $birthday = date(self::DATE_FORMAT, strtotime($birthday));

        return floor(($now - $birthday) / 10000);
    }
}
