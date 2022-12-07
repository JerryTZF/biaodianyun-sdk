<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/7 11:02
 * Author: JerryTian<tzfforyou@163.com>
 * File: Client.php
 * Desc:
 */

namespace Biaodianyun\sdk\model\flowers;

use Biaodianyun\Sdk\Config;
use Biaodianyun\Sdk\OpenAPIClient;

class Client extends OpenAPIClient
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
    }


}