<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/9 10:45
 * Author: JerryTian<tzfforyou@163.com>
 * File: BdyRequest.php
 * Desc:
 */

namespace Biaodianyun\Sdk;

abstract class BdyRequest
{
    // 请求类型
    public $contentType = 'application/json';

    // 请求体类型
    public $bodyType = 'json';

    // 是否 DEBUG 模式
    public $isDebug = false;

    // SSL 验证
    public $isSSL = false;

    // 超时时间
    public $timeout = 5.0;

    // 请求方法
    public $httpMethod = 'GET';

    // 域名(无网关时使用)
    public $domain;

    // 无网关路径(无网关时路径)
    public $path;

    // 网关自定义的path
    public $gatewayPath;

    // QUERY 键值对
    public $querys = [];

    // HEADERS 键值对
    public $headers = [];

    // PARAMS 键值对
    public $params = [];

    // 通用设置参数
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}
