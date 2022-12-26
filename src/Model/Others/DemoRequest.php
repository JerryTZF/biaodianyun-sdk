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
    public $gatewayPath = 'index.index.wxshare';

    // 是否 DEBUG 模式
    public $isDebug = false;

    // SSL 验证
    public $isSSL = false;

    // 超时时间
    public $timeout = 5.0;

    // 域名(无网关时使用)
    public $domain;

    // 无网关路径(无网关时路径)
    public $path;

    // QUERY 键值对
    public $querys = [];

    // HEADERS 键值对
    public $headers = [];

    // PARAMS 键值对
    public $params = [];

    // 该请求是无参数的请求, 如果需要构建特殊参数, 可以自己封装
    // 这里是一个例子
    public function setId(int $id): void
    {
        $this->params['id'] = $id;
    }
}
