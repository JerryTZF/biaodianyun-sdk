<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * Time: 2022/12/7 11:02
 * Author: JerryTian<tzfforyou@163.com>
 * File: FlowersClient.php
 * Desc:
 */

namespace Biaodianyun\Sdk\Model\Flowers;

use Biaodianyun\Sdk\Config;
use Biaodianyun\Sdk\Gateways;
use Biaodianyun\Sdk\Middleware\GatewayMiddleware;
use Biaodianyun\Sdk\OpenAPIClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class FlowersClient extends OpenAPIClient
{
    protected Client $client;

    protected HandlerStack $stack;

    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->client = new Client();

        // 根据 `gateway` 判断使用何种中间件
        $gatewayType = $this->gateway === '' ? '' : Gateways::MAP[$this->gateway];

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        if ($gatewayType !== '') {
            $func = $gatewayType === 'APISIX' ? 'apisixSign' : 'bdySign';
            $stack->push(GatewayMiddleware::$func());
        }
        $this->stack = $stack;
    }

    // 列举你的服务中都有哪些API
    public function getMediaInfo(Request $request): array
    {
        $path = $request;
        $u = 'https://sc-videos.sc.k8s.biaodianyun.com/ims/get_media_info';
        try {
            $response = $this->client->post($u, [
                'handler' => $this->stack,
                'json' => ['media' => 'https://jerry-markdown.oss-cn-shenzhen.aliyuncs.com/music/mzcl_.wav'],
                'debug' => true,
            ])->getBody()->getContents();
            var_dump($response);
        } catch (GuzzleException $e) {
            var_dump($e->getMessage());
            return [];
        }

        return [];
    }
}
