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

use Biaodianyun\Sdk\Middleware\GatewayMiddleware;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class OpenAPIClient
{
    // 业务秘钥KEY
    protected $accessKey;

    // 业务秘钥
    protected $secret;

    // 网关
    protected $gateway;

    public function __construct(Config $config)
    {
        [$this->accessKey, $this->secret, $this->gateway] = [
            $config->getAccessKey(),
            $config->getSecret(),
            $config->getGateway()
        ];
    }

    /**
     * @throws Exception
     */
    public function send(BdyRequest $request)
    {
        // 中间件
        $gatewayType = $this->gateway === '' ? '' : Gateways::MAP[$this->gateway];

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        if ($gatewayType !== '') {
            $func = ($gatewayType === 'APISIX') ? 'apisixSign' : 'bdySign';
            $stack->push(GatewayMiddleware::$func($this->accessKey, $this->secret));
        }

        // gateway 和 domain 至少填写一个
        if ($this->gateway === '' && $request->domain === '') {
            throw new Exception('gateway or domain is required :(');
        }
        // 根据bodyType判断
        if (!in_array($request->bodyType, ['json', 'form_params', 'multipart'])) {
            throw new Exception('illegal body type. choose one of json、form_params、multipart :(');
        }


        $domain = $this->gateway ?: $request->domain;
        $uri = $gatewayType !== '' ? $domain . $request->gatewayPath : $domain . $request->path;

        // 构建 OPTIONS
        $options = [
            'handler' => $stack,
            'query' => $request->querys,
            'headers' => $request->headers,
            'timeout' => $request->timeout,
            'verify' => $request->isSSL,
            'debug' => $request->isDebug,
            $request->bodyType => $request->params,
        ];

        try {
            $client = new Client(['handler' => $stack]);
            $response = $client->request($request->httpMethod, $uri, $options)->getBody()->getContents();
            var_dump($response);
        } catch (GuzzleException $e) {
            var_dump($e->getMessage());
        }
    }
}
