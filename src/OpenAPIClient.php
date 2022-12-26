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

    // 网关错误码定义
    protected const GATEWAY_ERROR_CODES = [
        '20000' => '服务不可用',
        '20001' => '网关不可用',
        '20002' => '授权权限不足',
        '20003' => '签名错误',
        '40001' => '缺少必要参数',
        '40002' => '非法的参数',
        '40004' => '业务处理失败',
        '40005' => '调用频率过高',
        '50001' => 'POI 中台内部错误',
        '50002' => 'POI 中台系统繁忙',
        '50003' => 'POI 中台请求参数错误',
        '50004' => 'POI 中台锁获取失败',
        '50101' => '已处于审核中的挂在信息',
        '50201' => '挂载信息不存在',
        '50202' => '当前状态不允许取消挂载'
    ];

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
     * @throws GuzzleException
     */
    public function send(BdyRequest $request)
    {
        // 中间件
        $gatewayType = $this->gateway ?: Gateways::MAP[$this->gateway];

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
        $uri = $gatewayType !== '' ? $domain . DIRECTORY_SEPARATOR . $request->gatewayPath :
            $domain . DIRECTORY_SEPARATOR . $request->path;

        // 构建 OPTIONS
        $options = [
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
            $response = json_decode($response, true) ?? [];
            if (
                isset($response['code']) &&
                in_array($response['code'], array_keys(self::GATEWAY_ERROR_CODES))) {
                $response['message'] ='网关错误, ' . self::GATEWAY_ERROR_CODES[$response['code']];
            }
            return $response;
        } catch (GuzzleException|Exception $e) {
            throw new $e();
        }
    }
}
