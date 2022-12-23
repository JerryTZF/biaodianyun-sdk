<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/23 09:42
 * Author: JerryTian<tzfforyou@163.com>
 * File: DemoRequest.php
 * Desc:
 */


namespace Biaodianyun\Sdk\Model\Others;

use Biaodianyun\Sdk\BdyRequest;

class DemoRequest extends BdyRequest
{
    // 请求类型
    public $contentType = 'application/json';

    // 请求体类型
    public $bodyType = 'json';

    // 请求方法
    public $httpMethod = 'POST';

    // 网关自定义的path
    public $gatewayPath = '/index.index.wxshare';
}