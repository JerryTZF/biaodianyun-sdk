<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/8 15:48
 * Author: JerryTian<tzfforyou@163.com>
 * File: Util.php
 * Desc:
 */


namespace Biaodianyun\Sdk;

class Util
{
    public static function utcDateTime()
    {
        //时区
        $timezone = date_default_timezone_get();
        if($timezone !== 'UTC'){
            //设置为UTC时间
            date_default_timezone_set('UTC');
            //获取时间
            $datetime = date(DATE_RFC7231);
            //还原时区
            date_default_timezone_set($timezone);
        }else{
            //UTC时间
            $datetime = date(DATE_RFC7231);
        }
        return $datetime;
    }
}