<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/7 11:53
 * Author: JerryTian<tzfforyou@163.com>
 * File: GatewayMiddleware.php
 * Desc:
 */

namespace Biaodianyun\Sdk\Middleware;

use Psr\Http\Message\RequestInterface;

class GatewayMiddleware
{
    public static function apisixSign(): \Closure
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                // TODO 你的中间件逻辑
                $request = $request->withHeader('xxx', 'xxx');
                return $handler($request, $options);
            };
        };
    }

    public static function bdySign(): \Closure
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                // TODO 你的中间件逻辑

                return $handler($request, $options);
            };
        };
    }
}
