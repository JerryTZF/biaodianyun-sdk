<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/7 10:34
 * Author: JerryTian<tzfforyou@163.com>
 * File: Gateways.php
 * Desc:
 */

namespace Biaodianyun\Sdk;

class Gateways
{
    // APISIX 正式地址
    public const APISIX_MASTER = 'http//gateway.tools.biaodianyun.com/gateway.do';

    // APISIX 测试地址
    public const APISIX_DEV = 'http://dev.gateway.tools.biaodianyun.com/gateway.do';

    // APISIX 正式地址(公网测试)
    public const APISIX_MASTER_PUBLIC = 'http://gateway.biaodianyun.com/gateway.do';

    // 自研网关 正式地址
    public const BDY_MASTER = 'http://gw-production.sc.k8s.biaodianyun.com';

    // 自研网关 正式地址(公网测试)
    public const BDY_MASTER_PUBLIC = 'http://gw-production-bdy.sc.k8s.biaodianyun.com';

    // 自研网关 测试地址
    public const BDY_DEV = 'http://gw-develop.dev.sc.k8s.biaodianyun.com';

    public const MAP = [
        'http://gateway.tools.biaodianyun.com/gateway.do' => 'APISIX',
        'http://dev.gateway.tools.biaodianyun.com/gateway.do' => 'APISIX',
        'http://gateway.biaodianyun.com/gateway.do' => 'APISIX',
        'http://gw-production.sc.k8s.biaodianyun.com' => 'BDY',
        'http://gw-production-bdy.sc.k8s.biaodianyun.com' => 'BDY',
        'http://gw-develop.dev.sc.k8s.biaodianyun.com' => 'BDY',
    ];
}
