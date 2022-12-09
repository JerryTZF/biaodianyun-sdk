<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Biaodianyun\Sdk\Config;
use Biaodianyun\Sdk\Gateways;
use Biaodianyun\Sdk\Model\Flowers\FlowersClient;
use Biaodianyun\Sdk\Model\Flowers\GetMediaInfoRequest;

$config = new Config();
$config->setGateway(Gateways::APISIX_MASTER_PUBLIC);
$config->setAccessKey('xxx');
$config->setSecret('xxx');

$client = new FlowersClient($config);

$request = new GetMediaInfoRequest();
$request->media = 'https://jerry-markdown.oss-cn-shenzhen.aliyuncs.com/music/mzcl_.wav';

$client->getMediaInfo($request);

function main()
{
    $request = new \http\Client\Request('GET','',[],'');
}
