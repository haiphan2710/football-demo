<?php

namespace HaiPG\LaravelCore\Common;

use Illuminate\Support\Facades\DB;

class StringHelper
{
    public static function mbTrim($str)
    {
        $str = preg_replace("/^[\s]+/u", '', $str);

        return preg_replace("/[\s]+$/u", '', $str);
    }

    public static function escapeBeforeSearch($str)
    {
        return str_replace('_', '\_', str_replace('%', '\%', str_replace('\\', '\\\\', $str)));
    }

    public static function randomStr($length = 6)
    {
        $string = "";
        $alpha  = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

        for ($i = 0; $i < $length; $i++) {
            $string .= $alpha[rand(0, strlen($alpha)-1)];
        }

        return $string;
    }

    public static function randomNumber($length)
    {
        $string = "";
        $alpha  = "0123456789";

        for ($i = 0; $i < $length; $i++) {
            $string .= $alpha[rand(0, strlen($alpha)-1)];
        }

        return $string;
    }

    public static function formatBankNumber($data)
    {
        $bankNumber = isset($data) && (strlen($data) < 7)
            ? str_pad($data, 7, '0', STR_PAD_LEFT)
            : $data;

        return $bankNumber;
    }

    public static function convertKanaFullSize(String $string)
    {
        return strtoupper(mb_convert_kana($string, 'aKVs'));
    }

    public static function cutStringByNumberChar(string $string, int $number)
    {
        return mb_strlen($string) > $number ? mb_substr($string, 0, $number) : $string;
    }

    public static function fillFullname($model, $input)
    {
        $fullname = StringHelper::escapeBeforeSearch($input);

        return $model->where(function ($query) use ($fullname) {
            return $query->where(
                DB::raw("CONCAT(first_name, ' ', last_name)"),
                'LIKE',
                "%{$fullname}%"
            )->orWhere(
                DB::raw("CONCAT(first_name_kana, ' ', last_name_kana)"),
                'LIKE',
                "%{$fullname}%"
            );
        });
    }
}
