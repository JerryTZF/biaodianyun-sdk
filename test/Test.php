<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Biaodianyun\Sdk\Config;
use Biaodianyun\Sdk\Gateways;
use Biaodianyun\Sdk\Model\Flowers\GetMediaInfoRequest;
use Biaodianyun\Sdk\OpenAPIClient;

$config = new Config();
$config->setGateway(Gateways::BDY_DEV);
$config->setAccessKey('xxx');
$config->setSecret('xxx');

$client = new OpenAPIClient($config);

$request = new GetMediaInfoRequest();
$request->gatewayPath = '';
$request->setMedia('51c825b079bb71ed993a909488556302');
$request->isSSL = false;
$request->isDebug = true;

$client->send($request);
