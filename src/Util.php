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
    public const HEADER_X_APPKEY = 'X-AppKey';
    public const HEADER_X_SIGN = 'X-Sign';
    public const HEADER_X_SIGN_TYPE = 'X-Sign-Type';
    public const HEADER_X_TOKEN = 'X-Token';
    public const HEADER_X_METHOD = 'X-Method';
    public const HEADER_X_TIMESTAMP = 'X-Timestamp';
    public const HEADER_X_VERSION = 'X-Version';
    public const HEADER_X_HMAC_DIGEST = 'X-Hmac-Digest';    //body验签的摘要
    public const HEADER_X_HMAC_SIGNED_HEADERS = 'X-Hmac-Signed-Headers';    //要参与签名的header头
    public const HEADER_X_HMAC_ALGORITHM = 'X-Hmac-Algorithm';
    public const HEADER_X_HMAC_ACCESS_KEY = 'X-Hmac-Access-Key';
    public const HEADER_X_HMAC_SIGNATURE = 'X-Hmac-Signature';
    public const HEADER_DATE = 'Date';

    public static function utcDateTime()
    {
        //时区
        $timezone = date_default_timezone_get();
        if ($timezone !== 'UTC') {
            //设置为UTC时间
            date_default_timezone_set('UTC');
            //获取时间
            $datetime = date(DATE_RFC7231);
            //还原时区
            date_default_timezone_set($timezone);
        } else {
            //UTC时间
            $datetime = date(DATE_RFC7231);
        }
        return $datetime;
    }
}
