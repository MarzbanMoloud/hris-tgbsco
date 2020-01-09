<?php
/**
 * Created by PhpStorm.
 * User: Marzban
 * Date: 9/20/2019
 * Time: 4:06 PM
 */

namespace App\Services\DateConverter;


use Morilog\Jalali\Jalalian;


/**
 * Class DateConvertor
 * @package App\Services\DateConvertor
 */
class DateConverter
{
    /**
     * @param $date
     * @return int
     */
    public static function toTimestamp($date)
    {
        $jDate = explode('/', $date);
        return (new Jalalian($jDate[0], $jDate[1], $jDate[2]))->getTimestamp();
    }

    /**
     * @param $timestamp
     * @return string
     */
    public static function toJalali($timestamp)
    {
        $jDate = Jalalian::forge($timestamp);
        return $jDate->getYear() . '/' . $jDate->getMonth() . '/' . $jDate->getDay();
    }
}