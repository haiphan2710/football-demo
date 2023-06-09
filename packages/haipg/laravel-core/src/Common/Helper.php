<?php

namespace HaiPG\LaravelCore\Common;

class Helper
{
    public static function jsonEncodeUnicode(array $data)
    {
        return preg_replace_callback(
            '/(?<!\\\\)\\\\u([0-9a-f]{4})/i',
            function ($match) {
                $binaryString = pack("H*", $match[1]);
                $stringReplace = mb_convert_encoding($binaryString, "UTF8", "UTF-16BE");

                return ($stringReplace !== "?" && $stringReplace !== "") ? $stringReplace : $match[0];
            },
            json_encode($data)
        );
    }

    public static function getAgeYear($birthdate)
    {
        $age = '';
        if (!empty($birthdate)) {
            $bits = explode('-', $birthdate);
            $age = date('Y') - $bits[0] - 1;
            $arr[1] = 'm';
            $arr[2] = 'd';

            for ($i = 1; $i <= count($arr); $i++) {
                $n = date($arr[$i]);
                if ($n < $bits[$i]) {
                    break;
                }
                if ($n > $bits[$i]) {
                    ++$age;
                    break;
                }
            }
        }

        if ($age == -1) {
            $age = 0;
        }

        if ($age < 20) {
            return '10代まで';
        } elseif ($age >= 20 && $age < 30) {
            return '20代';
        } elseif ($age >= 30 && $age < 40) {
            return '30代';
        } elseif ($age >= 40 && $age < 50) {
            return '40代';
        } elseif ($age >= 50 && $age < 60) {
            return '50代';
        } elseif ($age >= 60 && $age < 70) {
            return '60代';
        } elseif ($age >= 70) {
            return '70代以上';
        }
    }

    public static function properParseStr($str)
    {
        # result array
        $arr = [];

        # split on outer delimiter
        $pairs = explode('&', $str);

        # loop through each pair
        foreach ($pairs as $i) {
            # split into name and value
            list($name, $value) = explode('=', $i, 2);

            # if name already exists
            if (isset($arr[$name])) {
                # stick multiple values into an array
                if (is_array($arr[$name])) {
                    $arr[$name][] = $value;
                } else {
                    $arr[$name] = array($arr[$name], $value);
                }
            } # otherwise, simply stick it in a scalar
            else {
                $arr[$name] = $value;
            }
        }

        return $arr;
    }

    /*
     * convert soap results in SOAP-ENV
     */
    public static function convertXmlToJson($soap, $prefix)
    {
        $xml       = simplexml_load_string($soap);
        $xmlResult = $xml->children('SOAP-ENV', true)->Body->children($prefix, true);

        return json_encode($xmlResult);
    }
}
