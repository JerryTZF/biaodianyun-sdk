<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/6 13:51
 * Author: JerryTian<tzfforyou@163.com>
 * File: OpenAPIClient.php
 * Desc:
 */

namespace Biaodianyun\Sdk;

abstract class OpenAPIClient
{
    // 业务秘钥KEY
    protected string $accessKey;

    // 业务秘钥
    protected string $secret;

    // 网关
    protected string $gateway;

    public function __construct(Config $config)
    {
        [$this->accessKey, $this->secret, $this->gateway] = [
            $config->getAccessKey(),
            $config->getSecret(),
            $config->getGateway()
        ];
    }

    // 显式声明网关(可以动态变更网关)
    public function setGateway(string $gateway = ''): OpenAPIClient
    {
        $this->gateway = $gateway;
        return $this;
    }

    public function handle(){}
}
