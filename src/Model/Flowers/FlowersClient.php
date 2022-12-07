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
use Biaodianyun\Sdk\Middleware\ApisixMiddleware;
use Biaodianyun\Sdk\OpenAPIClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class FlowersClient extends OpenAPIClient
{
    protected Client $client;

    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->client = new Client();
    }

    // 列举你的服务中都有哪些API

    public function getMediaInfo(Request $request): array
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push(ApisixMiddleware::sign());
        $url = $this->gateway;
        $u = 'http://sc-videos.sc.k8s.biaodianyun.com/ims/get_media_info';
        try {
            $response = $this->client->post($u, [
                'handler' => $stack,
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
