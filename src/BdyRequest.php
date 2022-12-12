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
    public string $contentType = 'application/json';

    // 请求体类型
    public string $bodyType = 'json';

    // 是否客气 DEBUG 模式
    public bool $isDebug = false;

    // SSL 验证
    public bool $isSSL = false;

    // 超时时间
    public float $timeout = 5.0;

    // 请求方法
    public string $httpMethod = 'GET';

    // 域名(无网关时使用)
    public string $domain;

    // 无网关路径(无网关时路径)
    public string $path;

    // 网关自定义的path
    public string $gatewayPath;

    // QUERY 键值对
    public array $querys = [];

    // HEADERS 键值对
    public array $headers = [];

    // PARAMS 键值对
    public array $params = [];
}
