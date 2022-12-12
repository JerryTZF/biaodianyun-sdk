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

use Biaodianyun\Sdk\Util;
use Psr\Http\Message\RequestInterface;

class GatewayMiddleware
{
    public static function apisixSign(string $key, string $secret): \Closure
    {
        return function (callable $handler) use ($key, $secret) {
            return function (RequestInterface $request, array $options) use ($handler, $key, $secret) {
                [$date, $timestamp] = [Util::utcDateTime(), time()];

                // 添加 Date 头
                $request->withHeader('Date', $date);

                // 待签名头
                $needSignHeaders = [
                    strtoupper(Util::HEADER_X_APPKEY) => $key,
                    strtoupper(Util::HEADER_X_METHOD) => $request->getMethod(),
                    strtoupper(Util::HEADER_X_SIGN_TYPE) => 'hmac-sha256',
                    strtoupper(Util::HEADER_X_TIMESTAMP) => $timestamp,
                    strtoupper(Util::HEADER_X_VERSION) => '1.0',
                ];
                // 头信息加签
                $signHeaderString = (function () use ($request, $timestamp, $needSignHeaders) {
                    ksort($needSignHeaders);
                    $r = [];
                    foreach ($needSignHeaders as $header => $value) {
                        $r[] = sprintf('%s:%s', $header, $value);
                    }

                    return implode("\n", $r);
                })();

                // 已签名的头信息
                $signedHeaderString = implode(';', array_keys($needSignHeaders));

                // body
                $bodyString = $request->getBody()->getContents();

                // 获取排序后的 query
                $sortedQueryString = (function () use ($request) {
                    // 解析query
                    parse_str($request->getUri()->getQuery(), $queryArray);
                    // 正序query
                    ksort($queryArray);
                    return http_build_query($queryArray);
                })();

                // 待签名 字符串
                $signedString = implode("\n", [
                    $request->getMethod(),
                    $request->getUri()->getPath(),
                    $sortedQueryString,
                    $key,
                    $date,
                    $signHeaderString,
                    null,
                ]);

                // 计算签名
                $sign = base64_encode(hash_hmac('sha256', $signedString, $key, true));
                // body 摘要
                $bodyDigest = base64_encode(hash_hmac('sha256', $bodyString, $key, true));

                $needWithHeaders = [
                    Util::HEADER_X_APPKEY => $key,
                    Util::HEADER_X_METHOD => $request->getMethod(),
                    Util::HEADER_X_TIMESTAMP => $timestamp,
                    Util::HEADER_X_VERSION => '1.0',
                    Util::HEADER_X_SIGN_TYPE => 'hmac-sha256',
                    Util::HEADER_X_HMAC_DIGEST => $bodyDigest,
                    Util::HEADER_X_SIGN => $sign,

                    Util::HEADER_X_HMAC_ALGORITHM => 'hmac-sha256',
                    Util::HEADER_X_HMAC_ACCESS_KEY => $key,
                    Util::HEADER_X_HMAC_SIGNATURE => $sign,
                    Util::HEADER_DATE => $date,
                    Util::HEADER_X_HMAC_SIGNED_HEADERS => $signedHeaderString,
                ];

                // 添加头
                foreach ($needWithHeaders as $key => $value) {
                    $request = $request->withHeader(strtoupper($key), $value);
                }
                // 替换 QUERY
                $request = $request->withUri($request->getUri()->withQuery($sortedQueryString));
                // 开启 SSL 验证
                $options['verify'] = true;
                return $handler($request, $options);
            };
        };
    }

    public static function bdySign(string $key, string $secret): \Closure
    {
        return function (callable $handler) use ($key, $secret) {
            return function (RequestInterface $request, array $options) use ($handler, $key, $secret) {
                $timestamp = time();
                // 获取排序后的 query
                $sortedQueryString = (function () use ($request) {
                    // 解析query
                    parse_str($request->getUri()->getQuery(), $queryArray);
                    // 正序query
                    ksort($queryArray);
                    return http_build_query($queryArray);
                })();

                // 待签名头
                $needSignHeaders = [
                    strtoupper(Util::HEADER_X_APPKEY) => $key,
                    strtoupper(Util::HEADER_X_SIGN_TYPE) => 'hmac-sha256',
                    strtoupper(Util::HEADER_X_TIMESTAMP) => $timestamp,
                    strtoupper(Util::HEADER_X_VERSION) => '1.0',
                ];

                $signHeaderString = (function () use ($request, $timestamp, $needSignHeaders) {
                    ksort($needSignHeaders);
                    $r = [];
                    foreach ($needSignHeaders as $header => $value) {
                        $r[] = sprintf('%s:%s', $header, $value);
                    }

                    return implode("\n", $r);
                })();

                $bodyString = $request->getBody()->getContents();

                $signedString = implode("\n", [
                    $request->getMethod(),
                    $request->getUri()->getPath() . $request->getUri()->getQuery(),
                    $signHeaderString,
                    $bodyString
                ]);

                $sign = hash_hmac('sha256', $signedString, $key);

                $needWithHeaders = [
                    Util::HEADER_X_SIGN_TYPE => 'hmac-sha256',
                    Util::HEADER_X_APPKEY => $key,
                    Util::HEADER_X_SIGN => $sign,
                    Util::HEADER_X_METHOD => $request->getMethod(),
                    Util::HEADER_X_VERSION => '1.0',
                    Util::HEADER_X_TIMESTAMP => $timestamp,
                ];

                foreach ($needWithHeaders as $key => $value) {
                    $request = $request->withHeader(strtoupper($key), $value);
                }
                $request = $request->withUri($request->getUri()->withQuery($sortedQueryString));
                $options['verify'] = true;

                return $handler($request, $options);
            };
        };
    }
}
