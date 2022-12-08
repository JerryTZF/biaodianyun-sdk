<?php

namespace Biaodianyun\Sdk\Model\Flowers;

abstract class Request
{
    // 请求类型
    public string $contentType = 'application/json';

    // 请求体类型
    public string $bodyType = 'json';

    // 超时时间
    public float $timeout = 5.0;

    // 请求方法
    public string $httpMethod = 'GET';

    // 域名(无网关时使用)
    public string $domain;

    // 无网关路径(无网关时路径)
    public string $path;

    // QUERY 键值对
    public array $query;

    // PARAMS 键值对
    public array $params;

    public function setQuery(string $key, string $value): void
    {
        $this->query[$key] = $value;
    }

    public function setQueryArray(array $query): void
    {
        $this->query = $query;
    }
}
