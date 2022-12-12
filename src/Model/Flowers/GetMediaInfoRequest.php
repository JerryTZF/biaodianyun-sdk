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

use Biaodianyun\Sdk\BdyRequest;

class GetMediaInfoRequest extends BdyRequest
{
    public $bodyType = 'json';

    public $contentType = 'application/json';

    public $domain = 'https://sc-videos.sc.k8s.biaodianyun.com';

    public $path = '/ims/get_media_info';

    public $httpMethod = 'POST';

    public $isDebug = true;

    public $gatewayPath = 'xx.xx.xx';

    public function setMedia(string $media): void
    {
        $this->params['media'] = $media;
    }
}
