<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/7 11:08
 * Author: JerryTian<tzfforyou@163.com>
 * File: GetMediaInfoRequest.php
 * Desc:
 */

namespace Biaodianyun\Sdk\Model\Flowers;

class GetMediaInfoRequest extends Request
{
    // body类型
    public string $bodyType = 'json';

    // 域名(当走网关时, 域名为网关)
    public string $domain = 'https://sc-videos.sc.k8s.biaodianyun.com';

    // 路径
    public string $path = 'ims/get_media_info';

    // 请求方法
    public string $httpMethod = 'POST';
}
