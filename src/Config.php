<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/7 09:54
 * Author: JerryTian<tzfforyou@163.com>
 * File: Config.php
 * Desc:
 */

namespace Biaodianyun\Sdk;

// 后续可扩展该类, 丰富对应的配置项
class Config
{
    protected $accessKey = '';

    protected $secret = '';

    protected $gateway = '';

    public function setAccessKey(string $accessKey): void
    {
        $this->accessKey = $accessKey;
    }

    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    public function setGateway(string $gateway): void
    {
        $this->gateway = $gateway;
    }

    public function getAccessKey(): string
    {
        return $this->accessKey ?: '';
    }

    public function getSecret(): string
    {
        return $this->secret ?: '';
    }

    public function getGateway(): string
    {
        return $this->gateway ?: '';
    }
}
